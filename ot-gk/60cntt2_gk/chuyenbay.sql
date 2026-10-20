-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 20, 2026 lúc 02:47 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `chuyenbay`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chuyenbay`
--

CREATE TABLE `chuyenbay` (
  `ma_chuyen_bay` varchar(10) NOT NULL,
  `so_hieu` varchar(20) NOT NULL,
  `ma_tp_khoi_hanh` varchar(10) NOT NULL,
  `ngay_khoi_hanh` date NOT NULL,
  `ma_tp_den` varchar(10) NOT NULL,
  `ngay_den` date NOT NULL,
  `gia_ve` decimal(12,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chuyenbay`
--

INSERT INTO `chuyenbay` (`ma_chuyen_bay`, `so_hieu`, `ma_tp_khoi_hanh`, `ngay_khoi_hanh`, `ma_tp_den`, `ngay_den`, `gia_ve`) VALUES
('CB01', 'VN101', 'HN', '2026-11-01', 'NT', '2026-11-01', 1500000),
('CB02', 'VJ202', 'SG', '2026-11-02', 'NT', '2026-11-02', 900000),
('CB03', 'VN303', 'NT', '2026-11-05', 'TYO', '2026-11-05', 5200000),
('CB04', 'QH404', 'NT', '2026-11-07', 'HN', '2026-11-07', 1300000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quocgia`
--

CREATE TABLE `quocgia` (
  `ma_quoc_gia` varchar(10) NOT NULL,
  `ten_quoc_gia` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `quocgia`
--

INSERT INTO `quocgia` (`ma_quoc_gia`, `ten_quoc_gia`) VALUES
('JP', 'Nhật Bản'),
('KR', 'Hàn Quốc'),
('TH', 'Thái Lan'),
('VN', 'Việt Nam');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanhpho`
--

CREATE TABLE `thanhpho` (
  `ma_tp` varchar(10) NOT NULL,
  `ten_tp` varchar(100) NOT NULL,
  `ten_bang` varchar(100) DEFAULT NULL,
  `ma_quoc_gia` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thanhpho`
--

INSERT INTO `thanhpho` (`ma_tp`, `ten_tp`, `ten_bang`, `ma_quoc_gia`) VALUES
('HN', 'Hà Nội', 'Hà Nội', 'VN'),
('NT', 'Nha Trang', 'Khánh Hòa', 'VN'),
('SG', 'TP.HCM', 'TP.HCM', 'VN'),
('TYO', 'Tokyo', 'Kanto', 'JP');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chuyenbay`
--
ALTER TABLE `chuyenbay`
  ADD PRIMARY KEY (`ma_chuyen_bay`),
  ADD KEY `fk_cb_tp_khoihanh` (`ma_tp_khoi_hanh`),
  ADD KEY `fk_cb_tp_den` (`ma_tp_den`);

--
-- Chỉ mục cho bảng `quocgia`
--
ALTER TABLE `quocgia`
  ADD PRIMARY KEY (`ma_quoc_gia`);

--
-- Chỉ mục cho bảng `thanhpho`
--
ALTER TABLE `thanhpho`
  ADD PRIMARY KEY (`ma_tp`),
  ADD KEY `fk_thanhpho_quocgia` (`ma_quoc_gia`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chuyenbay`
--
ALTER TABLE `chuyenbay`
  ADD CONSTRAINT `fk_cb_tp_den` FOREIGN KEY (`ma_tp_den`) REFERENCES `thanhpho` (`ma_tp`),
  ADD CONSTRAINT `fk_cb_tp_khoihanh` FOREIGN KEY (`ma_tp_khoi_hanh`) REFERENCES `thanhpho` (`ma_tp`);

--
-- Các ràng buộc cho bảng `thanhpho`
--
ALTER TABLE `thanhpho`
  ADD CONSTRAINT `fk_thanhpho_quocgia` FOREIGN KEY (`ma_quoc_gia`) REFERENCES `quocgia` (`ma_quoc_gia`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
