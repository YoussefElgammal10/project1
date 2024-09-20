<?php
class Manager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // تسجيل مدير جديد
    public function register($name, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO managers (name, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $hashedPassword]);
    }

    // تسجيل الدخول
    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM managers WHERE email = ?");
        $stmt->execute([$email]);
        $manager = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($manager && password_verify($password, $manager['password'])) {
            $_SESSION['manager_id'] = $manager['id'];
            return true;
        }
        return false;
    }

    // استرجاع الموظفين
    public function getEmployees($managerId) {
        $stmt = $this->db->prepare("SELECT * FROM employees WHERE manager_id = ?");
        $stmt->execute([$managerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // إضافة موظف جديد
    public function addEmployee($name, $email, $phone, $picture, $managerId) {
        $stmt = $this->db->prepare("INSERT INTO employees (name, email, phone, picture, manager_id) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $phone, $picture, $managerId]);
    }

    // تحديث تفاصيل الموظف
    public function updateEmployee($id, $name, $email, $phone, $picture) {
        $stmt = $this->db->prepare("UPDATE employees SET name = ?, email = ?, phone = ?, picture = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $phone, $picture, $id]);
    }

    
    // حذف موظف
    public function deleteEmployee($id) {
        $stmt = $this->db->prepare("DELETE FROM employees WHERE id = ?");
        return $stmt->execute([$id]);
    }
     
    
    // استرجاع جميع المدرا
    public function getManagers() {
        $stmt = $this->db->query("SELECT * FROM managers");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // تحديث تفاصيل المدير
    public function updateManager($id, $name, $email, $password) {
        // If password is empty, keep the existing password
        if (empty($password)) {
            $stmt = $this->db->prepare("UPDATE managers SET name = ?, email = ? WHERE id = ?");
            return $stmt->execute([$name, $email, $id]);
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE managers SET name = ?, email = ?, password = ? WHERE id = ?");
            return $stmt->execute([$name, $email, $hashedPassword, $id]);
        }
    }

    // حذف مدير
    public function deleteManager($id) {
        $stmt = $this->db->prepare("DELETE FROM managers WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
