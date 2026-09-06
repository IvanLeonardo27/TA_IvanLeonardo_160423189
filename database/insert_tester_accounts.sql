-- ==============================================================================
-- QUERY INSERT LENGKAP AKUN TESTER & KELAS BASAKULA
-- - 10 Pengajar (testerpengajar01 - testerpengajar10) masing-masing punya 1 kelas
-- - 30 Pelajar (testerpelajar01 - testerpelajar30) masing-masing tergabung ke 1 kelas (3 pelajar / kelas)
-- - Password: tester123 (Bcrypt: $2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji)
-- Catatan: Kolom email_verified_at dan photo sudah di-drop dari tabel users.
-- ==============================================================================

-- ------------------------------------------------------------------------------
-- 1. INSERT DATA USERS PENGAJAR (10 AKUN)
-- ------------------------------------------------------------------------------
INSERT INTO `users` (`name`, `email`, `user_code`, `password`, `role_id`, `status`, `created_at`, `updated_at`)
VALUES
('Tester Pengajar 01', 'testerpengajar01@test.com', 'TPG01', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'teacher' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pengajar 02', 'testerpengajar02@test.com', 'TPG02', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'teacher' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pengajar 03', 'testerpengajar03@test.com', 'TPG03', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'teacher' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pengajar 04', 'testerpengajar04@test.com', 'TPG04', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'teacher' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pengajar 05', 'testerpengajar05@test.com', 'TPG05', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'teacher' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pengajar 06', 'testerpengajar06@test.com', 'TPG06', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'teacher' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pengajar 07', 'testerpengajar07@test.com', 'TPG07', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'teacher' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pengajar 08', 'testerpengajar08@test.com', 'TPG08', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'teacher' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pengajar 09', 'testerpengajar09@test.com', 'TPG09', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'teacher' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pengajar 10', 'testerpengajar10@test.com', 'TPG10', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'teacher' LIMIT 1), 'active', NOW(), NOW())
ON DUPLICATE KEY UPDATE `password` = VALUES(`password`), `role_id` = VALUES(`role_id`), `status` = 'active';

-- ------------------------------------------------------------------------------
-- 2. INSERT DATA USERS PELAJAR (30 AKUN)
-- ------------------------------------------------------------------------------
INSERT INTO `users` (`name`, `email`, `user_code`, `password`, `role_id`, `status`, `created_at`, `updated_at`)
VALUES
('Tester Pelajar 01', 'testerpelajar01@test.com', 'TPL01', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 02', 'testerpelajar02@test.com', 'TPL02', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 03', 'testerpelajar03@test.com', 'TPL03', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 04', 'testerpelajar04@test.com', 'TPL04', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 05', 'testerpelajar05@test.com', 'TPL05', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 06', 'testerpelajar06@test.com', 'TPL06', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 07', 'testerpelajar07@test.com', 'TPL07', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 08', 'testerpelajar08@test.com', 'TPL08', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 09', 'testerpelajar09@test.com', 'TPL09', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 10', 'testerpelajar10@test.com', 'TPL10', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 11', 'testerpelajar11@test.com', 'TPL11', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 12', 'testerpelajar12@test.com', 'TPL12', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 13', 'testerpelajar13@test.com', 'TPL13', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 14', 'testerpelajar14@test.com', 'TPL14', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 15', 'testerpelajar15@test.com', 'TPL15', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 16', 'testerpelajar16@test.com', 'TPL16', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 17', 'testerpelajar17@test.com', 'TPL17', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 18', 'testerpelajar18@test.com', 'TPL18', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 19', 'testerpelajar19@test.com', 'TPL19', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 20', 'testerpelajar20@test.com', 'TPL20', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 21', 'testerpelajar21@test.com', 'TPL21', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 22', 'testerpelajar22@test.com', 'TPL22', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 23', 'testerpelajar23@test.com', 'TPL23', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 24', 'testerpelajar24@test.com', 'TPL24', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 25', 'testerpelajar25@test.com', 'TPL25', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 26', 'testerpelajar26@test.com', 'TPL26', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 27', 'testerpelajar27@test.com', 'TPL27', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 28', 'testerpelajar28@test.com', 'TPL28', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 29', 'testerpelajar29@test.com', 'TPL29', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW()),
('Tester Pelajar 30', 'testerpelajar30@test.com', 'TPL30', '$2y$10$RfGSQDW52p1h1M4wJwdbY.XANZ47xnMED2holkscZeghxcmIOz0ji', (SELECT `id` FROM `roles` WHERE `name` = 'student' LIMIT 1), 'active', NOW(), NOW())
ON DUPLICATE KEY UPDATE `password` = VALUES(`password`), `role_id` = VALUES(`role_id`), `status` = 'active';

-- ------------------------------------------------------------------------------
-- 3. PROFIL PENGAJAR (teacher_profiles)
-- ------------------------------------------------------------------------------
INSERT INTO `teacher_profiles` (`user_id`, `nip`, `institution_name`, `subject_specialization`, `created_at`, `updated_at`)
SELECT `id`, CONCAT('19800101', LPAD(`id`, 4, '0')), 'SMP/SMA Negeri BasaKula', 'Bahasa & Sastra Jawa', NOW(), NOW()
FROM `users` WHERE `email` LIKE 'testerpengajar%@test.com'
ON DUPLICATE KEY UPDATE `updated_at` = NOW();

-- ------------------------------------------------------------------------------
-- 4. PROFIL PELAJAR (student_profiles)
-- ------------------------------------------------------------------------------
INSERT INTO `student_profiles` (`user_id`, `nisn`, `school_name`, `grade_level`, `created_at`, `updated_at`)
SELECT `id`, CONCAT('008', LPAD(`id`, 7, '0')), 'SMP/SMA Negeri BasaKula', 'Kelas 8', NOW(), NOW()
FROM `users` WHERE `email` LIKE 'testerpelajar%@test.com'
ON DUPLICATE KEY UPDATE `updated_at` = NOW();

-- ------------------------------------------------------------------------------
-- 5. BUAT 10 KELAS (MASING-MASING PENGAJAR MEMILIKI 1 KELAS)
-- ------------------------------------------------------------------------------
INSERT INTO `classrooms` (`teacher_id`, `name`, `subject`, `code`, `description`, `banner_color`, `banner_icon`, `status`, `created_at`, `updated_at`)
VALUES
((SELECT `id` FROM `users` WHERE `email` = 'testerpengajar01@test.com' LIMIT 1), 'Kelas Gladhen Basa Jawa 01', 'Bahasa & Sastra Jawa', 'TEST-CLS01', 'Ruang kelas uji coba pembelajaran Basa Jawa untuk Pengajar 01.', '#16402E', 'fa-book', 'active', NOW(), NOW()),
((SELECT `id` FROM `users` WHERE `email` = 'testerpengajar02@test.com' LIMIT 1), 'Kelas Gladhen Basa Jawa 02', 'Bahasa & Sastra Jawa', 'TEST-CLS02', 'Ruang kelas uji coba pembelajaran Basa Jawa untuk Pengajar 02.', '#16402E', 'fa-book', 'active', NOW(), NOW()),
((SELECT `id` FROM `users` WHERE `email` = 'testerpengajar03@test.com' LIMIT 1), 'Kelas Gladhen Basa Jawa 03', 'Bahasa & Sastra Jawa', 'TEST-CLS03', 'Ruang kelas uji coba pembelajaran Basa Jawa untuk Pengajar 03.', '#16402E', 'fa-book', 'active', NOW(), NOW()),
((SELECT `id` FROM `users` WHERE `email` = 'testerpengajar04@test.com' LIMIT 1), 'Kelas Gladhen Basa Jawa 04', 'Bahasa & Sastra Jawa', 'TEST-CLS04', 'Ruang kelas uji coba pembelajaran Basa Jawa untuk Pengajar 04.', '#16402E', 'fa-book', 'active', NOW(), NOW()),
((SELECT `id` FROM `users` WHERE `email` = 'testerpengajar05@test.com' LIMIT 1), 'Kelas Gladhen Basa Jawa 05', 'Bahasa & Sastra Jawa', 'TEST-CLS05', 'Ruang kelas uji coba pembelajaran Basa Jawa untuk Pengajar 05.', '#16402E', 'fa-book', 'active', NOW(), NOW()),
((SELECT `id` FROM `users` WHERE `email` = 'testerpengajar06@test.com' LIMIT 1), 'Kelas Gladhen Basa Jawa 06', 'Bahasa & Sastra Jawa', 'TEST-CLS06', 'Ruang kelas uji coba pembelajaran Basa Jawa untuk Pengajar 06.', '#16402E', 'fa-book', 'active', NOW(), NOW()),
((SELECT `id` FROM `users` WHERE `email` = 'testerpengajar07@test.com' LIMIT 1), 'Kelas Gladhen Basa Jawa 07', 'Bahasa & Sastra Jawa', 'TEST-CLS07', 'Ruang kelas uji coba pembelajaran Basa Jawa untuk Pengajar 07.', '#16402E', 'fa-book', 'active', NOW(), NOW()),
((SELECT `id` FROM `users` WHERE `email` = 'testerpengajar08@test.com' LIMIT 1), 'Kelas Gladhen Basa Jawa 08', 'Bahasa & Sastra Jawa', 'TEST-CLS08', 'Ruang kelas uji coba pembelajaran Basa Jawa untuk Pengajar 08.', '#16402E', 'fa-book', 'active', NOW(), NOW()),
((SELECT `id` FROM `users` WHERE `email` = 'testerpengajar09@test.com' LIMIT 1), 'Kelas Gladhen Basa Jawa 09', 'Bahasa & Sastra Jawa', 'TEST-CLS09', 'Ruang kelas uji coba pembelajaran Basa Jawa untuk Pengajar 09.', '#16402E', 'fa-book', 'active', NOW(), NOW()),
((SELECT `id` FROM `users` WHERE `email` = 'testerpengajar10@test.com' LIMIT 1), 'Kelas Gladhen Basa Jawa 10', 'Bahasa & Sastra Jawa', 'TEST-CLS10', 'Ruang kelas uji coba pembelajaran Basa Jawa untuk Pengajar 10.', '#16402E', 'fa-book', 'active', NOW(), NOW())
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `status` = 'active';

-- ------------------------------------------------------------------------------
-- 6. DAFTARKAN PENGAJAR KE KELASNYA SEBAGAI ROLE 'TEACHER'
-- ------------------------------------------------------------------------------
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `created_at`, `updated_at`)
VALUES
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS01' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpengajar01@test.com' LIMIT 1), 'teacher', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS02' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpengajar02@test.com' LIMIT 1), 'teacher', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS03' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpengajar03@test.com' LIMIT 1), 'teacher', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS04' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpengajar04@test.com' LIMIT 1), 'teacher', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS05' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpengajar05@test.com' LIMIT 1), 'teacher', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS06' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpengajar06@test.com' LIMIT 1), 'teacher', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS07' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpengajar07@test.com' LIMIT 1), 'teacher', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS08' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpengajar08@test.com' LIMIT 1), 'teacher', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS09' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpengajar09@test.com' LIMIT 1), 'teacher', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS10' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpengajar10@test.com' LIMIT 1), 'teacher', NOW(), NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'teacher', `out_at` = NULL;

-- ------------------------------------------------------------------------------
-- 7. GABUNGKAN 30 PELAJAR KE MASING-MASING 1 KELAS (3 PELAJAR PER KELAS)
-- ------------------------------------------------------------------------------
INSERT INTO `classroom_members` (`classroom_id`, `user_id`, `role`, `joined_at`, `created_at`, `updated_at`)
VALUES
-- Kelas 01 (TEST-CLS01) -> Pelajar 01, 02, 03
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS01' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar01@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS01' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar02@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS01' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar03@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),

-- Kelas 02 (TEST-CLS02) -> Pelajar 04, 05, 06
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS02' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar04@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS02' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar05@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS02' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar06@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),

-- Kelas 03 (TEST-CLS03) -> Pelajar 07, 08, 09
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS03' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar07@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS03' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar08@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS03' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar09@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),

-- Kelas 04 (TEST-CLS04) -> Pelajar 10, 11, 12
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS04' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar10@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS04' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar11@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS04' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar12@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),

-- Kelas 05 (TEST-CLS05) -> Pelajar 13, 14, 15
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS05' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar13@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS05' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar14@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS05' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar15@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),

-- Kelas 06 (TEST-CLS06) -> Pelajar 16, 17, 18
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS06' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar16@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS06' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar17@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS06' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar18@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),

-- Kelas 07 (TEST-CLS07) -> Pelajar 19, 20, 21
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS07' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar19@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS07' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar20@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS07' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar21@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),

-- Kelas 08 (TEST-CLS08) -> Pelajar 22, 23, 24
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS08' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar22@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS08' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar23@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS08' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar24@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),

-- Kelas 09 (TEST-CLS09) -> Pelajar 25, 26, 27
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS09' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar25@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS09' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar26@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS09' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar27@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),

-- Kelas 10 (TEST-CLS10) -> Pelajar 28, 29, 30
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS10' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar28@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS10' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar29@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW()),
((SELECT `id` FROM `classrooms` WHERE `code` = 'TEST-CLS10' LIMIT 1), (SELECT `id` FROM `users` WHERE `email` = 'testerpelajar30@test.com' LIMIT 1), 'student', NOW(), NOW(), NOW())
ON DUPLICATE KEY UPDATE `role` = 'student', `out_at` = NULL;
