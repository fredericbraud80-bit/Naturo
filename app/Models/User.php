<?php
namespace App\Models;

use App\Core\Database;

final class User
{
    public static function findByEmail(string $email): ?array { $stmt = Database::connection()->prepare('SELECT * FROM users WHERE email = ?'); $stmt->execute([$email]); return $stmt->fetch() ?: null; }
    public static function all(): array { return Database::connection()->query('SELECT * FROM users ORDER BY created_at DESC')->fetchAll(); }
    public static function create(array $data): void { $stmt = Database::connection()->prepare('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)'); $stmt->execute([$data['name'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT), $data['role'] ?? 'user']); }
    public static function updateRole(int $id, string $role): void { $stmt = Database::connection()->prepare('UPDATE users SET role = ? WHERE id = ?'); $stmt->execute([$role, $id]); }
    public static function delete(int $id): void { $stmt = Database::connection()->prepare('DELETE FROM users WHERE id = ?'); $stmt->execute([$id]); }
}
