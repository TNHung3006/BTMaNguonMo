<?php
require_once __DIR__ . '/src/ApiClient.php';

use AddressConverter\ApiClient;

$client = new ApiClient();

// Lấy danh sách Tỉnh/Thành phố
$provincesRes = $client->getProvinces();
$provinces = $provincesRes['success'] ? $provincesRes['data'] : [];

// Giá trị mặc định (như hình mẫu: TP. Hồ Chí Minh, Quận 5, Phường 11)
$selectedProvince = $_GET['province'] ?? '79';
$selectedDistrict = $_GET['district'] ?? '774';
$selectedWard     = $_GET['ward']     ?? '27328';
$street           = $_GET['street']   ?? '';

// Lấy danh sách quận/huyện và phường/xã ban đầu tương ứng
$districtsRes = $selectedProvince ? $client->getDistricts($selectedProvince) : ['data' => []];
$districts = $districtsRes['success'] ? $districtsRes['data'] : [];

$wardsRes = $selectedDistrict ? $client->getWards($selectedDistrict) : ['data' => []];
$wards = $wardsRes['success'] ? $wardsRes['data'] : [];

// Lấy kết quả chuyển đổi ban đầu
$convertResult = null;
if ($selectedProvince && $selectedDistrict && $selectedWard) {
    $res = $client->convertAddress($selectedProvince, $selectedDistrict, $selectedWard, $street);
    if ($res['success']) {
        $convertResult = $res['data'];
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chuyển đổi địa chỉ cũ sang mới</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">
    <!-- Header -->
    <header class="page-header">
        <h1 class="page-title">Chuyển đổi địa chỉ cũ sang mới</h1>
        <p class="page-subtitle">Gõ tự do hoặc chọn theo danh sách. Kết quả gồm địa chỉ mới, mã hành chính và căn cứ sáp nhập.</p>
    </header>

    <!-- Form Container -->
    <div class="form-card">
        <!-- Tabs -->
        <nav class="tabs-nav" aria-label="Hình thức chuyển đổi">
            <button type="button" class="tab-btn" onclick="alert('Tính năng Gõ tự do đang được phát triển, vui lòng dùng Chọn theo danh sách!')">Gõ tự do</button>
            <button type="button" class="tab-btn active">Chọn theo danh sách</button>
        </nav>

        <div class="card-body">
            <form id="convert-form" method="GET" action="index.php">
                <!-- Dropdown 3 cấp -->
                <div class="form-grid">
                    <!-- Tỉnh/Thành phố -->
                    <div class="form-group no-margin">
                        <label class="form-label" for="province-select">Tỉnh/Thành phố (cũ)</label>
                        <div class="input-select-wrapper">
                            <select id="province-select" name="province" class="form-select" required>
                                <option value="">— Chọn —</option>
                                <?php foreach ($provinces as $p): ?>
                                    <option value="<?= htmlspecialchars($p['code']) ?>" <?= $selectedProvince === $p['code'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($p['full_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="select-arrow">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="m6 9 6 6 6-6"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <!-- Quận/Huyện -->
                    <div class="form-group no-margin">
                        <label class="form-label" for="district-select">Quận/Huyện (cũ)</label>
                        <div class="input-select-wrapper">
                            <select id="district-select" name="district" class="form-select" data-initial-selected="<?= htmlspecialchars($selectedDistrict) ?>" required <?= empty($districts) ? 'disabled' : '' ?>>
                                <option value="">— Chọn —</option>
                                <?php foreach ($districts as $d): ?>
                                    <option value="<?= htmlspecialchars($d['code']) ?>" <?= $selectedDistrict === $d['code'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($d['full_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="select-arrow">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="m6 9 6 6 6-6"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <!-- Phường/Xã -->
                    <div class="form-group no-margin">
                        <label class="form-label" for="ward-select">Phường/Xã (cũ)</label>
                        <div class="input-select-wrapper">
                            <select id="ward-select" name="ward" class="form-select" data-initial-selected="<?= htmlspecialchars($selectedWard) ?>" required <?= empty($wards) ? 'disabled' : '' ?>>
                                <option value="">— Chọn —</option>
                                <?php foreach ($wards as $w): ?>
                                    <option value="<?= htmlspecialchars($w['code']) ?>" <?= $selectedWard === $w['code'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($w['full_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="select-arrow">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="m6 9 6 6 6-6"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Số nhà, tên đường -->
                <div class="form-group">
                    <label class="form-label" for="street-input">Số nhà, tên đường (không bắt buộc — giữ nguyên sau chuyển đổi)</label>
                    <input type="text" id="street-input" name="street" class="form-input" placeholder="" value="<?= htmlspecialchars($street) ?>">
                </div>

                <!-- Nút chuyển đổi -->
                <div class="form-actions">
                    <button type="submit" id="btn-convert" class="btn-convert">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 3 4 7l4 4"/>
                            <path d="M4 7h16"/>
                            <path d="m16 21 4-4-4-4"/>
                            <path d="M20 17H4"/>
                        </svg>
                        <span>Chuyển đổi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Kết quả chuyển đổi -->
    <section id="result-section" class="result-section" style="<?= $convertResult ? '' : 'display: none;' ?>">
        <?php if ($convertResult): 
            $oldInfo = $convertResult['old'] ?? [];
            $newInfo = $convertResult['new'] ?? [];
            $mergeInfo = $convertResult['mergeInfo'] ?? [];
            $detailUrl = $newInfo['detail_url'] ?? ('https://www.tinhthanhpho.com/' . ($newInfo['province']['slug'] ?? '') . '/' . ($newInfo['ward']['slug'] ?? ''));
        ?>
            <div class="result-grid">
                <!-- ĐỊA CHỈ CŨ -->
                <div class="result-card card-old">
                    <div class="eyebrow-row">
                        <span class="eyebrow eyebrow-old">ĐỊA CHỈ CŨ · TRƯỚC 1/7/2025</span>
                    </div>
                    <div class="result-address" id="old-address-text"><?= htmlspecialchars($oldInfo['fullAddress'] ?? '') ?></div>
                    <hr class="card-divider">
                    <div class="data-table">
                        <div class="data-row">
                            <span class="data-label">Phường/Xã</span>
                            <span class="data-value"><?= htmlspecialchars(($oldInfo['ward']['type'] ?? 'Phường') . ' ' . ($oldInfo['ward']['name'] ?? '')) ?> <span class="code-tag">#<?= htmlspecialchars($oldInfo['ward']['code'] ?? '') ?></span></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label">Quận/Huyện</span>
                            <span class="data-value"><?= htmlspecialchars(($oldInfo['district']['type'] ?? 'Quận') . ' ' . ($oldInfo['district']['name'] ?? '')) ?> <span class="code-tag">#<?= htmlspecialchars($oldInfo['district']['code'] ?? '') ?></span></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label">Tỉnh/TP</span>
                            <span class="data-value"><?= htmlspecialchars(($oldInfo['province']['type'] ?? '') . ' ' . ($oldInfo['province']['name'] ?? '')) ?> <span class="code-tag">#<?= htmlspecialchars($oldInfo['province']['code'] ?? '') ?></span></span>
                        </div>
                    </div>
                </div>

                <!-- ĐỊA CHỈ MỚI -->
                <div class="result-card card-new">
                    <div class="eyebrow-row">
                        <span class="eyebrow eyebrow-new">ĐỊA CHỈ MỚI · TỪ 1/7/2025</span>
                        <span class="badge-success">✓ Khớp chính xác</span>
                    </div>
                    <div class="result-address result-address-new" id="new-address-text"><?= htmlspecialchars($newInfo['fullAddress'] ?? '') ?></div>
                    <hr class="card-divider">
                    <div class="data-table">
                        <div class="data-row">
                            <span class="data-label">Phường/Xã</span>
                            <span class="data-value"><?= htmlspecialchars(($newInfo['ward']['type'] ?? 'Phường') . ' ' . ($newInfo['ward']['name'] ?? '')) ?> <span class="code-tag">#<?= htmlspecialchars($newInfo['ward']['code'] ?? '') ?></span></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label">Tỉnh/TP</span>
                            <span class="data-value"><?= htmlspecialchars(($newInfo['province']['type'] ?? '') . ' ' . ($newInfo['province']['name'] ?? '')) ?> <span class="code-tag">#<?= htmlspecialchars($newInfo['province']['code'] ?? '') ?></span></span>
                        </div>
                    </div>

                    <div class="result-actions">
                        <button type="button" class="btn-copy" id="btn-copy-address" data-copy="<?= htmlspecialchars($newInfo['fullAddress'] ?? '') ?>">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                                <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                            </svg>
                            <span>Sao chép địa chỉ mới</span>
                        </button>
                        <a href="<?= htmlspecialchars($detailUrl) ?>" target="_blank" rel="noopener" class="btn-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span>Xem chi tiết <?= htmlspecialchars(($newInfo['ward']['type'] ?? 'Phường') . ' ' . ($newInfo['ward']['name'] ?? '')) ?></span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Vì sao địa chỉ thay đổi -->
            <?php if (!empty($mergeInfo['notes'])): ?>
            <div class="why-box">
                <svg class="why-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 16v-4"/>
                    <path d="M12 8h.01"/>
                </svg>
                <div>
                    <div class="why-title">Vì sao địa chỉ thay đổi?</div>
                    <div class="why-desc"><?= htmlspecialchars($mergeInfo['notes']) ?></div>
                    <?php if (!empty($mergeInfo['legal'])): ?>
                        <div class="why-legal">Căn cứ: <strong><?= htmlspecialchars($mergeInfo['legal']) ?></strong></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- JSON API Details Collapsible -->
            <details class="details-box">
                <summary class="details-summary">
                    <span>Dữ liệu JSON / gọi qua API</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </summary>
                <div class="details-content">
                    <span class="api-endpoint-badge">POST /api/v1/convert/address</span>
                    <pre class="json-pre"><?= htmlspecialchars(json_encode($convertResult, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre>
                </div>
            </details>
        <?php endif; ?>
    </section>
</div>

<!-- Toast notification popup -->
<div id="toast" class="toast">Đã sao chép vào clipboard! ✓</div>

<script src="assets/js/app.js"></script>
</body>
</html>

