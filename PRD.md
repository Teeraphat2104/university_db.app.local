# 📄 Product Requirements Document (PRD)

## ระบบจัดการเอกสาร (Document Management System)

---

## 1. 🎯 วัตถุประสงค์ (Objective)

พัฒนาระบบจัดการเอกสารสำหรับเจ้าหน้าที่ เพื่อให้สามารถ:

* ค้นหาเอกสารได้อย่างรวดเร็ว
* ลดปัญหาเอกสารสูญหาย
* จัดเก็บข้อมูลแบบศูนย์กลาง (Centralized)
* เพิ่มประสิทธิภาพการทำงานขององค์กร

---

## 2. 👥 กลุ่มผู้ใช้งาน (Users)

### 2.1 Admin

* จัดการเอกสาร (เพิ่ม / แก้ไข / ลบ)
* จัดการหมวดหมู่
* จัดการผู้ใช้งาน

### 2.2 User (เจ้าหน้าที่ทั่วไป)

* ค้นหาเอกสาร
* ดู / ดาวน์โหลดเอกสาร

---

## 3. 🧩 Features หลัก (Core Features)

### 3.1 ระบบค้นหาเอกสาร

* ค้นหาจาก:

  * ชื่อเอกสาร (keyword)
  * ปี
  * หมวดหมู่
* แสดงผลแบบ Real-time (AJAX)

---

### 3.2 ระบบจัดการเอกสาร (CRUD)

#### เพิ่มเอกสาร

* ชื่อเอกสาร
* หมวดหมู่
* ปี
* อัปโหลดไฟล์ (PDF, Excel, Word)

#### แก้ไขเอกสาร

* แก้ไขข้อมูล metadata
* อัปโหลดไฟล์ใหม่

#### ลบเอกสาร

* ลบแบบ soft delete (แนะนำ)

---

### 3.3 ระบบหมวดหมู่ (Category Management)

* เพิ่ม / แก้ไข / ลบหมวดหมู่
* ใช้สำหรับจัดกลุ่มเอกสาร เช่น:

  * ผ่อนผัน
  * ทุนการศึกษา
  * เอกสารทั่วไป

---

### 3.4 ระบบแสดงผลเอกสาร

* แสดงรายการแบบ Table หรือ Card
* แสดงข้อมูล:

  * ชื่อเอกสาร
  * หมวดหมู่
  * ปี
  * วันที่อัปโหลด

---

### 3.5 Preview เอกสาร

* เปิดไฟล์ PDF ใน Browser
* รองรับ download

---

### 3.6 ระบบสิทธิ์ (Authorization)

* Admin → CRUD ได้ทั้งหมด
* User → อ่านอย่างเดียว

---

### 3.7 ระบบอัปโหลดไฟล์

* รองรับ:

  * PDF
  * XLSX
  * DOCX
* จำกัดขนาดไฟล์ (เช่น 10MB)

---

### 3.8 ระบบ Backup (Optional)

* เก็บไฟล์ใน:

  * Server
  * หรือ Cloud (AWS S3 / Google Drive)

---

## 4. 🗂 Database Design (เบื้องต้น)

### ตาราง: documents

| Field       | Type      | Description |
| ----------- | --------- | ----------- |
| id          | bigint    | Primary Key |
| title       | string    | ชื่อเอกสาร  |
| category_id | bigint    | FK หมวดหมู่ |
| year        | int       | ปี          |
| file_path   | string    | path ไฟล์   |
| created_by  | bigint    | ผู้สร้าง    |
| created_at  | timestamp | วันที่สร้าง |

---

### ตาราง: categories

| Field | Type   | Description  |
| ----- | ------ | ------------ |
| id    | bigint | Primary Key  |
| name  | string | ชื่อหมวดหมู่ |

---

## 5. 🧪 User Flow

### ค้นหาเอกสาร

1. ผู้ใช้เข้าหน้า “จัดการเอกสาร”
2. กรอก keyword หรือเลือก filter:

   * ปี
   * หมวดหมู่
3. กดค้นหา
4. ระบบแสดงผลทันที

---

### เพิ่มเอกสาร

1. Admin กด “เพิ่มเอกสาร”
2. กรอกข้อมูล
3. อัปโหลดไฟล์
4. กด Save
5. ระบบบันทึกข้อมูลและไฟล์

---

## 6. 🎨 UI/UX Requirements

* ใช้ Design แบบ Modern / Minimal
* มี:

  * Sidebar Navigation
  * Topbar (Search + Profile)
* มี:

  * Loading State
  * Empty State
* Responsive (Desktop เป็นหลัก)

---

## 7. ⚙️ Technical Stack

* Backend: Laravel
* Frontend: Blade + AJAX (jQuery)
* CSS: Tailwind CSS หรือ Bootstrap 5
* Database: MySQL

---

## 8. 🔐 Security

* ใช้ Authentication (Laravel Auth)
* ตรวจสอบสิทธิ์ (Middleware)
* ป้องกัน:

  * File Upload Attack
  * SQL Injection
  * CSRF

---

## 9. 📈 Future Enhancements

* Tag system (#สำคัญ)
* Version control เอกสาร
* Activity log
* Full-text search
* OCR (ค้นหาข้อความใน PDF)

---

## 10. ✅ Success Metrics

* เวลาค้นหาเอกสารลดลง
* ไม่มีปัญหาไฟล์สูญหาย
* ผู้ใช้งานสามารถเข้าถึงเอกสารได้ทันที

---

## 11. 🚀 Scope (MVP)

### Included

* CRUD เอกสาร
* ค้นหา
* หมวดหมู่
* อัปโหลดไฟล์

### Excluded (Phase 2)

* OCR
* AI Search
* Cloud Integration

---

# 📄 Document Controller Structure (Laravel)

โครงสร้าง Controller สำหรับระบบจัดการเอกสาร โดยใช้รูปแบบเดียวกับ `myShop()`:

* ใช้ `validate()`
* ใช้ `try/catch`
* ใช้ `$response` object
* return JSON format เดียวกันทุก API

---

## 📌 ตัวอย่าง: myShop (ต้นแบบ)

```php
public function myShop(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|integer',
    ]);

    $response = (object) [];

    try {
        $shops = Shop::where('user_id', $validated['user_id'])
            ->take(10)
            ->get();

        $data = $shops->map(function ($shop) {
            return $this->formatShop($shop);
        });

        $response->status = 200;
        $response->message = 'Shops retrieved successfully';
        $response->data = $data;

    } catch (\Exception $e) {
        $response->status = 500;
        $response->message = 'Failed to retrieve shops';
        $response->error = $e->getMessage();
    }

    return response()->json($response, $response->status);
}
```

---

# 🧩 Document APIs

## 1. 📄 Get Documents (List + Search)

```php
public function index(Request $request)
{
    $validated = $request->validate([
        'keyword' => 'nullable|string',
        'year' => 'nullable|integer',
        'category_id' => 'nullable|integer',
    ]);

    $response = (object) [];

    try {
        $query = Document::query();

        if (!empty($validated['keyword'])) {
            $query->where('title', 'like', '%' . $validated['keyword'] . '%');
        }

        if (!empty($validated['year'])) {
            $query->where('year', $validated['year']);
        }

        if (!empty($validated['category_id'])) {
            $query->where('category_id', $validated['category_id']);
        }

        $documents = $query->latest()->paginate(10);

        $data = $documents->map(function ($doc) {
            return $this->formatDocument($doc);
        });

        $response->status = 200;
        $response->message = 'Documents retrieved successfully';
        $response->data = $data;
        $response->pagination = [
            'current_page' => $documents->currentPage(),
            'last_page' => $documents->lastPage(),
            'total' => $documents->total(),
        ];

    } catch (\Exception $e) {
        $response->status = 500;
        $response->message = 'Failed to retrieve documents';
        $response->error = $e->getMessage();
    }

    return response()->json($response, $response->status);
}
```

---

## 2. ➕ Create Document

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'category_id' => 'required|integer',
        'year' => 'required|integer',
        'file' => 'required|file|max:10240',
    ]);

    $response = (object) [];

    try {

        $filePath = $request->file('file')->store('documents', 'public');

        $document = Document::create([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'year' => $validated['year'],
            'file_path' => $filePath,
            'created_by' => auth()->id(),
        ]);

        $response->status = 200;
        $response->message = 'Document created successfully';
        $response->data = $this->formatDocument($document);

    } catch (\Exception $e) {
        $response->status = 500;
        $response->message = 'Failed to create document';
        $response->error = $e->getMessage();
    }

    return response()->json($response, $response->status);
}
```

---

## 3. ✏️ Update Document

```php
public function update(Request $request, $id)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'category_id' => 'required|integer',
        'year' => 'required|integer',
        'file' => 'nullable|file|max:10240',
    ]);

    $response = (object) [];

    try {
        $document = Document::findOrFail($id);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents', 'public');
            $document->file_path = $filePath;
        }

        $document->update([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'year' => $validated['year'],
        ]);

        $response->status = 200;
        $response->message = 'Document updated successfully';
        $response->data = $this->formatDocument($document);

    } catch (\Exception $e) {
        $response->status = 500;
        $response->message = 'Failed to update document';
        $response->error = $e->getMessage();
    }

    return response()->json($response, $response->status);
}
```

---

## 4. 🗑 Delete Document

```php
public function destroy($id)
{
    $response = (object) [];

    try {
        $document = Document::findOrFail($id);
        $document->delete();

        $response->status = 200;
        $response->message = 'Document deleted successfully';

    } catch (\Exception $e) {
        $response->status = 500;
        $response->message = 'Failed to delete document';
        $response->error = $e->getMessage();
    }

    return response()->json($response, $response->status);
}
```

---

## 5. 🔧 Format Data

```php
private function formatDocument($doc)
{
    return [
        'id' => $doc->id,
        'title' => $doc->title,
        'category_id' => $doc->category_id,
        'year' => $doc->year,
        'file_url' => asset('storage/' . $doc->file_path),
        'created_at' => $doc->created_at,
    ];
}
```

---

# ✅ Response Format มาตรฐาน

```json
{
    "status": 200,
    "message": "Success",
    "data": [],
    "pagination": {}
}
```

---

# 🚀 Best Practice

* ใช้ `formatDocument()` แยก logic
* ใช้ `try/catch` ทุก endpoint
* ใช้ response format เดียวกันทั้งระบบ
* แนะนำเพิ่ม:

  * Soft Delete
  * Logging
  * Validation Message ภาษาไทย

---

# 📌 เหมาะสำหรับ

* Laravel + AJAX (jQuery)
* REST API
* Admin Dashboard


# 📌 หมายเหตุ

เอกสารนี้ออกแบบเพื่อใช้พัฒนา Web Application ด้วย Laravel และสามารถต่อยอดเป็นระบบองค์กรได้
