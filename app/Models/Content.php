<?php
namespace App\Models;

use App\Core\Database;

final class Content
{
    public static function all(?string $type = null): array
    {
        $sql = 'SELECT * FROM content'; $params = [];
        if ($type) { $sql .= ' WHERE type = ?'; $params[] = $type; }
        $sql .= ' ORDER BY created_at DESC';
        $stmt = Database::connection()->prepare($sql); $stmt->execute($params); return $stmt->fetchAll();
    }
    public static function create(array $data): void
    {
        $stmt = Database::connection()->prepare('INSERT INTO content (title, excerpt, body, image, video_url, type, is_live) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$data['title'], $data['excerpt'], $data['body'], $data['image'] ?: null, $data['video_url'] ?: null, $data['type'], $data['type'] === 'live' ? 1 : 0]);
    }
}
