<?php
$cfg = require __DIR__ . '/config.php';
require __DIR__ . '/ExchangeApi.php';
$api = new ExchangeApi($cfg);

// ---------- AJAX: trả JSON cho phần quy đổi ----------
if (isset($_GET['action']) && $_GET['action'] === 'convert') {
    header('Content-Type: application/json; charset=utf-8');
    try {
        $cur  = $_GET['cur']  ?? 'USD';
        $type = $_GET['type'] ?? 'cash';
        if (!in_array($type, ['cash', 'transfer', 'sell'], true)) {
            throw new InvalidArgumentException('Loại giá không hợp lệ');
        }
        if (!isset($cfg['currencies'][$cur])) {
            throw new InvalidArgumentException('Tiền tệ không được hỗ trợ');
        }
        $q = $api->quote($api->getRate($cur));
        echo json_encode(['ok' => true, 'rate' => $q[$type]]);
    } catch (Throwable $e) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// ---------- Lấy dữ liệu bảng tỷ giá ----------
$rows = []; $tableError = null;
try {
    foreach ($cfg['currencies'] as $code => $name) {
        $rows[$code] = ['name' => $name] + $api->quote($api->getRate($code));
    }
} catch (Throwable $e) {
    $tableError = $e->getMessage();
}
$fmt = fn($n) => number_format($n, 2, '.', ',');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Chuyển đổi ngoại tệ</title>
<style>
  :root { --green:#a2c23a; --green-dark:#8aab26; --bg:#fff; --text:#1d1d1d; --muted:#777; --line:#e5e5e5; }
  * { box-sizing:border-box; }
  body { font-family:'Segoe UI',Arial,sans-serif; color:var(--text); background:var(--bg); margin:0; padding:32px 16px; }
  .wrap { max-width:1100px; margin:0 auto; }
  h1,h2 { font-weight:600; margin:0 0 16px; }
  .top { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; }
  .tabs button { border:0; background:#f1f1f1; padding:12px 18px; border-radius:24px; font-size:16px; cursor:pointer; margin-right:8px; }
  .tabs button.active { background:var(--green); color:#fff; }
  .updated { color:var(--muted); font-size:14px; }
  .converter { display:grid; grid-template-columns:1fr 60px 1fr; gap:12px; align-items:end; margin:24px 0 40px; }
  .label { font-size:12px; font-weight:700; text-transform:uppercase; margin-bottom:8px; }
  .box { display:flex; align-items:center; gap:10px; border:1px solid var(--line); border-radius:6px; padding:0 16px; height:64px; }
  .box select, .box input { border:0; outline:0; font-size:22px; background:transparent; font-family:inherit; }
  .box input { flex:1; min-width:0; }
  .out { font-size:22px; font-weight:600; }
  .arrow { text-align:center; font-size:24px; color:var(--green-dark); }
  table { width:100%; border-collapse:collapse; border:1px solid var(--line); }
  th { background:var(--green); color:#fff; padding:14px; font-weight:500; }
  td { padding:14px; border-top:1px solid var(--line); }
  td.num { text-align:right; } td.c { text-align:center; }
  tr:nth-child(even) td { background:#fafafa; }
  .err { color:#c0392b; margin-top:8px; font-size:14px; }
  @media (max-width:700px){ .converter{grid-template-columns:1fr;} .arrow{transform:rotate(90deg);} }
</style>
</head>
<body>
<div class="wrap">
  <h1>Chuyển đổi ngoại tệ</h1>

  <div class="top">
    <div class="tabs" id="tabs">
      <button class="active" data-type="cash">Mua tiền mặt</button>
      <button data-type="transfer">Mua chuyển khoản</button>
      <button data-type="sell">Bán</button>
    </div>
    <div class="updated">Tỷ giá được cập nhật lúc <b><?= date('H:i \n\g\à\y d/m/Y') ?></b></div>
  </div>

  <div class="converter">
    <div>
      <div class="label" id="lblFrom">Số tiền quý khách cần bán</div>
      <div class="box">
        <select id="cur">
          <?php foreach ($cfg['currencies'] as $code => $name): ?>
            <option value="<?= htmlspecialchars($code) ?>"><?= htmlspecialchars($code) ?></option>
          <?php endforeach; ?>
        </select>
        <input id="amount" type="text" inputmode="decimal" value="1" autocomplete="off">
      </div>
    </div>
    <div class="arrow">➜</div>
    <div>
      <div class="label">Số tiền quý khách sẽ nhận</div>
      <div class="box"><span>VND</span><span class="out" id="result">0</span></div>
      <div class="err" id="err"></div>
    </div>
  </div>

  <h2>Tỷ giá ngoại tệ</h2>
  <?php if ($tableError): ?>
    <p class="err">Không tải được bảng tỷ giá: <?= htmlspecialchars($tableError) ?></p>
  <?php else: ?>
  <table>
    <tr><th>Mã ngoại tệ</th><th>Tên ngoại tệ</th><th>Mua tiền mặt</th><th>Mua chuyển khoản</th><th>Bán</th></tr>
    <?php foreach ($rows as $code => $r): ?>
    <tr>
      <td class="c"><?= htmlspecialchars($code) ?></td>
      <td class="c"><?= htmlspecialchars($r['name']) ?></td>
      <td class="num"><?= $fmt($r['cash']) ?></td>
      <td class="num"><?= $fmt($r['transfer']) ?></td>
      <td class="num"><?= $fmt($r['sell']) ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
  <?php endif; ?>
</div>

<script>
let type = 'cash';
const $ = id => document.getElementById(id);

// Gọi server lấy tỷ giá rồi nhân với số tiền
async function recalc() {
  $('err').textContent = '';
  // Chuẩn hoá: bỏ dấu phẩy ngăn cách, chỉ cho số dương
  const amount = parseFloat($('amount').value.replace(/,/g, ''));
  if (isNaN(amount) || amount < 0) {
    $('result').textContent = '0';
    if ($('amount').value.trim() !== '') $('err').textContent = 'Vui lòng nhập số hợp lệ (>= 0)';
    return;
  }
  try {
    const res = await fetch(`?action=convert&cur=${$('cur').value}&type=${type}`);
    const data = await res.json();
    if (!data.ok) throw new Error(data.error);
    $('result').textContent = (amount * data.rate).toLocaleString('vi-VN', { maximumFractionDigits: 0 });
  } catch (e) {
    $('err').textContent = 'Lỗi: ' + e.message;
  }
}

// Đổi tab
$('tabs').addEventListener('click', e => {
  if (e.target.tagName !== 'BUTTON') return;
  document.querySelectorAll('#tabs button').forEach(b => b.classList.remove('active'));
  e.target.classList.add('active');
  type = e.target.dataset.type;
  $('lblFrom').textContent = type === 'sell' ? 'Số tiền quý khách cần mua' : 'Số tiền quý khách cần bán';
  recalc();
});

$('amount').addEventListener('input', recalc);
$('cur').addEventListener('change', recalc);
recalc();
</script>
</body>
</html>
