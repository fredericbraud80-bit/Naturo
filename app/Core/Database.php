<?php
namespace App\Core;

use PDO;

final class Database
{
    private static PDO $db;
    public static function set(PDO $db): void { self::$db = $db; }
    public static function connection(): PDO { return self::$db; }
    public static function migrate(): void
    {
        self::$db->exec("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, email TEXT UNIQUE NOT NULL, password TEXT NOT NULL, role TEXT NOT NULL DEFAULT 'user', created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP);
        CREATE TABLE IF NOT EXISTS content (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT NOT NULL, excerpt TEXT NOT NULL, body TEXT NOT NULL, image TEXT, video_url TEXT, type TEXT NOT NULL DEFAULT 'conseil', is_live INTEGER NOT NULL DEFAULT 0, created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP);");
        $count = (int) self::$db->query('SELECT COUNT(*) FROM users')->fetchColumn();
        if ($count === 0) {
            $stmt = self::$db->prepare('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)');
            $stmt->execute(['Rachel Cayzac', 'admin@rachel-naturo.fr', password_hash('rachel2026', PASSWORD_DEFAULT), 'admin']);
            $stmt->execute(['Camille Durand', 'camille@example.com', password_hash('bienvenue', PASSWORD_DEFAULT), 'user']);
        }
        $contentCount = (int) self::$db->query('SELECT COUNT(*) FROM content')->fetchColumn();
        if ($contentCount === 0) {
            $stmt = self::$db->prepare('INSERT INTO content (title, excerpt, body, image, video_url, type, is_live) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute(['Le rituel du matin', '3 gestes doux pour commencer la journée avec énergie.', 'Respirer, s hydrater et s offrir quelques minutes de mouvement : un petit rituel qui change tout. Découvrez les gestes simples de Rachel pour réveiller votre vitalité.', 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&w=900&q=80', null, 'conseil', 0]);
            $stmt->execute(['Bien respirer avec les huiles', 'Une initiation guidée aux huiles essentielles du quotidien.', 'Dans ce replay, Rachel vous accompagne pas à pas pour créer une atmosphère apaisante chez vous, avec douceur et prudence.', null, 'https://www.youtube.com/watch?v=ysz5S6PUM-U', 'archive', 0]);
            $stmt->execute(['Live : les essentiels de l automne', 'Retrouvez Rachel mercredi à 19h pour préparer la saison.', 'Posez vos questions en direct et repartez avec des routines naturopathiques simples.', null, 'https://www.youtube.com/watch?v=ysz5S6PUM-U', 'live', 1]);
        }
    }
}
