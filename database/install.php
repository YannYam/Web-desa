<?php
/**
 * Database Installer — Desa Bragang
 * Run once: php database/install.php
 */

$dbPath = __DIR__ . '/desa_bragang.db';

if (file_exists($dbPath)) {
    echo "⚠  Database already exists at: $dbPath\n";
    echo "   Delete it first if you want to reinstall.\n";
    exit(1);
}

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Run schema
    echo "📦 Creating tables...\n";
    $schema = file_get_contents(__DIR__ . '/schema.sql');
    $pdo->exec($schema);

    // Run seed
    echo "🌱 Seeding data...\n";
    $seed = file_get_contents(__DIR__ . '/seed.sql');
    $pdo->exec($seed);

    // Create default admin user
    echo "👤 Creating admin user...\n";
    $hash = password_hash('admin123', PASSWORD_BCRYPT);
    $stmt = $pdo->prepare('INSERT INTO users (username, password, nama) VALUES (?, ?, ?)');
    $stmt->execute(['admin', $hash, 'Administrator']);

    echo "\n✅ Installation complete!\n";
    echo "   Database: $dbPath\n";
    echo "   Admin login: admin / admin123\n";
    echo "\n   Start server: php -S localhost:8000\n";

} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
