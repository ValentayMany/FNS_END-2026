# FNS Financial Management System — Agent Skill / Project Guide

เอกสารนี้ใช้เป็นแนวทางสำหรับ AI และนักพัฒนาเมื่อทำงานใน repo **FNS_END-2026** (ระบบบริหารการเงินระดับคณะ มหาวิทยาลัย)

**อัปเดตล่าสุด:** 30 พ.ค. 2026

---

## ภาพรวมระบบ

| รายการ | รายละเอียด |
|--------|------------|
| Framework | Laravel 12, PHP 8.2+ |
| Frontend | Blade + Tailwind CSS + Vite |
| Database | MySQL (production มักเป็น remote — ระวัง connection limit) |
| ภาษา UI | ພາສາລາວ (หลัก) |
| Auth | Session-based (Laravel Breeze), login ด้วย `username` |

### โมดูลหลัก

1. **Advance Request** — เบิกเงินทดรอง (Requester) + workflow อนุมัติ 4 ขั้น  
2. **Cashier** — จ่ายเงินหลัง `approved` → สร้าง `Transaction` (expense)  
3. **Clearing** — ส่งใบสะสาง + แนบไฟล์ → Accountant ยืนยัน  
4. **Revenue / Expense** — บันทึกรายรับ-รายจ่ายทั่วไป  
5. **Reports** — Ledger รวม, filter, export Excel  
6. **Treasurer / Treasury Reconciliation**  
7. **Admin** — จัดการ role, เปิด/ปิด user  

### บทบาท (10 roles)

`admin`, `requester`, `accountant`, `head_of_finance`, `deputy_head_of_faculty`, `head_of_faculty`, `cashier`, `revenue_officer`, `treasurer`, `treasury_reconciliation_officer`

- Route ควบคุมด้วย middleware `role:...` → `App\Http\Middleware\CheckRole`
- ผู้ใช้ที่ `is_active = false` ถูก logout โดย `EnsureUserIsActive` (กลุ่ม `web`) และตอน login

### Workflow สถานะคำขอเบิก

```
draft → pending_accountant_review → pending_finance_head_review
  → pending_deputy_head_approval → pending_faculty_head_approval
  → approved → paid → pending_clearing → cleared
```

Logic หลักอยู่ที่ `App\Services\WorkflowService`

---

## โครงสร้างไฟล์สำคัญ

```
app/Http/Controllers/     # Controllers ตามโมดูล
app/Services/WorkflowService.php
app/Http/Middleware/CheckRole.php
app/Http/Middleware/EnsureUserIsActive.php
app/Http/Middleware/DisconnectDatabase.php   # ตัด DB หลัง request (remote DB)
app/Models/               # User, AdvanceRequest, Transaction, ...
app/Support/LaoText.php   # normalize ລຽ້ງ mark order
routes/web.php
routes/auth.php
config/fns.php            # การตั้งค่าเฉพาะโปรเจกต์
resources/views/          # Blade แยกตามโมดูล
task.md                   # สถานะฟีเจอร์ / bug fixes เก่า
system_summary.md.resolved
```

---

## กฎและข้อควรระวัง (สำคัญ)

### รายงานการเงิน — อย่านับซ้ำ advance payment

- Cashier สร้าง `Transaction` type `expense` เมื่อจ่ายเบิก  
- ในรายงาน (`ReportController`, `TreasurerController`) **กรอง transaction ที่ผูก `AdvanceRequest.payment_transaction_id` ออก** แล้วรวมยอดจาก `AdvanceRequest` แยก  
- หน้า Expense ของ Accountant **ไม่แสดง** transaction ที่ `whereDoesntHave('advanceRequest')` และ **ห้าม** edit/delete (ใช้ `ensureEditableExpense()`)

### Clearing

- Route ดาวน์โหลดไฟล์: `clearing.download` (ไม่ใช่ `clearing.attachment.download`)  
- Requester `clearing.index`: แสดง `paid` และ `pending_clearing`  
- ส่ง clearing: **อัปโหลดไฟล์ก่อน** แล้วค่อย `WorkflowService::submitClearing()` (ใน `DB::transaction`)  
- ไฟล์เก็บ disk `local` — ดาวน์โหลดผ่าน `ClearingController::downloadAttachment` เท่านั้น  

### อนุมัติ

- `approve` / `reject` ต้องผ่าน `canBeActedBy()`  
- `approvals.show` ใช้ `canViewApproval()` — approver เห็นได้เฉพาะคำขอที่ไม่ใช่ `draft` หรืออยู่ในขั้นของตัวเอง  

### รายจ่าย (Expense) — Metadata ใน description

- DB ไม่มีคอลัมน์ `expense_type`, `channel_type` แยก — เก็บใน `description` เป็น  
  `[ປະເພດລາຍຈ່າຍ: ...] [ຊ່ອງ ປຕ/ປທ: ...]` + ข้อความผู้ใช้  
- `edit()` ส่งตัวแปร: `$transaction`, `$expenseType`, `$channelType`, `$userDesc`  
- View `expense/edit.blade.php` ต้องใช้ตัวแปรเหล่านี้ (**ไม่ใช้** `$expense`)

### การสมัครสมาชิก

- ค่าเริ่มต้นปิด: `config('fns.allow_registration')` ← `FNS_ALLOW_REGISTRATION` (default `false`)  
- Route `/register` และลิงก์ในหน้า login แสดงเฉพาะเมื่อเปิด  

### Migrations / Tests

- Repo มี migration ส่วนใหญ่เป็น `alter table` — **ไม่มี** migration สร้างตารางหลัก (`users`, `transactions`, `advance_requests`, ...)  
- `php artisan test` บน SQLite จะล้มจนกว่าจะมี schema ครบ — production ที่มี DB อยู่แล้วไม่กระทบ  

---

## การตั้งค่า (.env)

```env
# เปิดให้สมัครสมาชิกเอง (ค่าเริ่มต้นปิด)
FNS_ALLOW_REGISTRATION=false

# หลังแก้ config
# php artisan config:clear
```

---

## รายงาน (ReportController)

- Filter: `type` = `daily` | `monthly` | `yearly`  
- Validate ผ่าน `validatedReportFilters()`: `date` (Y-m-d), `month` (YYYY-MM), `year` (YYYY)  
- `revenue_officer` เห็นเฉพาะ income; `accountant` เห็นเฉพาะ expense (ในรายงาน)  
- Export Excel: `ReportExcelExportService` + route `reports.export`  

---

## UI/UX — ฟอร์มรายจ่าย (Expense Forms)

### การปรับปรุง UI

- **Modern Vertical Stack Layout**: หัวข้ออยู่บน input — responsive  
- **2-Column Grid**: ฟิลด์สั้น (วันที่, ປີງົບປະມານ, บัญชี)  
- **Soft styling**: `bg-gray-50/50`, `rounded-xl`, Indigo focus ring  
- **ปุ่ม**: SVG + hover shadow  

### Auto-Sync ປີງົບປະມານ

- เมื่อเปลี่ยน `transaction_date` → sync ปีไปช่อง budget year (JS ใน `expense.blade.php` / `edit.blade.php`)

### ไฟล์ที่เกี่ยวข้อง

- `resources/views/expense/expense.blade.php` — เพิ่มรายจ่าย  
- `resources/views/expense/edit.blade.php` — แก้ไข (ใช้ `$transaction`, `$expenseType`, `$channelType`, `$userDesc`)  
- `app/Http/Controllers/ExpenseController.php` — store/update + `ensureEditableExpense()`  

---

## บั๊กที่แก้แล้ว (30 พ.ค. 2026)

| # | ปัญหา | การแก้ |
|---|--------|--------|
| 1 | หน้า `expense/edit` ใช้ `$expense` แต่ controller ส่ง `$transaction` | แก้ Blade + ใช้ `$expenseType`, `$channelType`, `$userDesc` |
| 2 | Route ดาวน์โหลด clearing ชื่อผิด | `clearing.download` ใน `clearing.blade.php` |
| 3 | ลบ/แก้ transaction จ่ายเบิกจาก Cashier ได้ | กรองรายการ + `ensureEditableExpense()` |
| 4 | Clearing เปลี่ยน status ก่อน upload / requester หายจาก list | upload ก่อน + แสดง `pending_clearing` |
| 5 | User ปิดแล้วยังใช้ route `auth` ได้ | `EnsureUserIsActive` middleware |
| 6 | IDOR `approvals.show` | `canViewApproval()` |
| 7 | Report ไม่ validate date/month | `validatedReportFilters()` |
| 8 | สมัครสมาชิกเปิดสาธารณะ | `config/fns.php` + ปิด route ค่าเริ่มต้น |

รอบก่อนหน้า (ดู `task.md`, `task.md.resolved`): route clearing, export yearly, filter รายงาน, treasurer ตามปี, budget report, sidebar, admin toggle user ฯลฯ

---

## เมื่อแก้โค้ด — แนวทาง

1. **ขอบเขตเล็ก** — อย่า refactor นอก scope  
2. **ตาม convention เดิม** — Blade components (`x-app-layout`), ข้อความลาว, ธีม Indigo  
3. **อย่า commit** เว้นแต่ user ขอ  
4. **อย่า commit** `.env` หรือ credentials  
5. ทดสอบ flow ที่เกี่ยวข้อง: role ที่ถูกต้อง, สถานะ advance request, รายงานไม่นับซ้ำ  
6. PowerShell: ใช้ `;` แทน `&&` สำหรับ chain command  

---

## คำสั่งที่ใช้บ่อย

```bash
php artisan serve
php artisan migrate
php artisan config:clear
php artisan test
composer run dev    # serve + queue + pail + vite
```

---

## เอกสารอ้างอิงใน repo

- `system_summary.md.resolved` — สรุประบบ + diagram workflow  
- `task.md` — สถานะโปรเจกต์ / bug fixes เม.ย. 2026  
- `task.md.resolved` — รายการ audit รอบ 1–3 (18 ข้อ)  
- `routes/web.php` — แผนที่ route ทั้งหมด  
