document.addEventListener('DOMContentLoaded', () => {
    const provinceSelect = document.getElementById('province-select');
    const districtSelect = document.getElementById('district-select');
    const wardSelect = document.getElementById('ward-select');
    const streetInput = document.getElementById('street-input');
    const convertForm = document.getElementById('convert-form');
    const btnConvert = document.getElementById('btn-convert');
    const resultSection = document.getElementById('result-section');
    const toast = document.getElementById('toast');

    // Hiển thị thông báo Toast
    function showToast(message) {
        if (!toast) return;
        toast.textContent = message;
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 2500);
    }

    // Load danh sách Quận/Huyện theo Tỉnh
    async function loadDistricts(provinceCode, selectedDistrictCode = null) {
        if (!provinceCode) {
            districtSelect.innerHTML = '<option value="">— Chọn —</option>';
            districtSelect.disabled = true;
            wardSelect.innerHTML = '<option value="">— Chọn —</option>';
            wardSelect.disabled = true;
            return;
        }

        districtSelect.disabled = true;
        districtSelect.innerHTML = '<option value="">Đang tải Quận/Huyện...</option>';
        wardSelect.innerHTML = '<option value="">— Chọn —</option>';
        wardSelect.disabled = true;

        try {
            const res = await fetch(`api/districts.php?province=${encodeURIComponent(provinceCode)}`);
            const json = await res.json();

            if (json.success && Array.isArray(json.data)) {
                let options = '<option value="">— Chọn —</option>';
                json.data.forEach(item => {
                    const isSelected = selectedDistrictCode && selectedDistrictCode === item.code ? 'selected' : '';
                    options += `<option value="${item.code}" ${isSelected}>${item.full_name}</option>`;
                });
                districtSelect.innerHTML = options;
                districtSelect.disabled = false;

                if (selectedDistrictCode) {
                    await loadWards(selectedDistrictCode, wardSelect.dataset.initialSelected);
                }
            } else {
                districtSelect.innerHTML = '<option value="">Không tìm thấy Quận/Huyện</option>';
            }
        } catch (err) {
            console.error('Lỗi tải quận huyện:', err);
            districtSelect.innerHTML = '<option value="">Lỗi tải dữ liệu</option>';
        }
    }

    // Load danh sách Phường/Xã theo Quận/Huyện
    async function loadWards(districtCode, selectedWardCode = null) {
        if (!districtCode) {
            wardSelect.innerHTML = '<option value="">— Chọn —</option>';
            wardSelect.disabled = true;
            return;
        }

        wardSelect.disabled = true;
        wardSelect.innerHTML = '<option value="">Đang tải Phường/Xã...</option>';

        try {
            const res = await fetch(`api/wards.php?district=${encodeURIComponent(districtCode)}`);
            const json = await res.json();

            if (json.success && Array.isArray(json.data)) {
                let options = '<option value="">— Chọn —</option>';
                json.data.forEach(item => {
                    const isSelected = selectedWardCode && selectedWardCode === item.code ? 'selected' : '';
                    options += `<option value="${item.code}" ${isSelected}>${item.full_name}</option>`;
                });
                wardSelect.innerHTML = options;
                wardSelect.disabled = false;
            } else {
                wardSelect.innerHTML = '<option value="">Không tìm thấy Phường/Xã</option>';
            }
        } catch (err) {
            console.error('Lỗi tải phường xã:', err);
            wardSelect.innerHTML = '<option value="">Lỗi tải dữ liệu</option>';
        }
    }

    // Lắng nghe sự kiện thay đổi Tỉnh
    if (provinceSelect) {
        provinceSelect.addEventListener('change', () => {
            loadDistricts(provinceSelect.value);
        });
    }

    // Lắng nghe sự kiện thay đổi Quận
    if (districtSelect) {
        districtSelect.addEventListener('change', () => {
            loadWards(districtSelect.value);
        });
    }

    // Khởi tạo load dữ liệu nếu đã có sẵn giá trị ban đầu
    if (provinceSelect && provinceSelect.value && districtSelect.dataset.initialSelected) {
        loadDistricts(provinceSelect.value, districtSelect.dataset.initialSelected);
    }

    // Xử lý nộp form chuyển đổi
    if (convertForm) {
        convertForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const province = provinceSelect.value;
            const district = districtSelect.value;
            const ward = wardSelect.value;
            const street = streetInput ? streetInput.value.trim() : '';

            if (!province || !district || !ward) {
                alert('Vui lòng chọn đầy đủ Tỉnh/Thành phố, Quận/Huyện và Phường/Xã!');
                return;
            }

            // Đổi trạng thái nút bấm
            btnConvert.disabled = true;
            const originalBtnHtml = btnConvert.innerHTML;
            btnConvert.innerHTML = '<span class="spinner"></span> Đang chuyển đổi...';

            try {
                const params = new URLSearchParams({
                    province: province,
                    district: district,
                    ward: ward,
                    street: street
                });

                const res = await fetch(`api/convert.php?${params.toString()}`);
                const result = await res.json();

                if (result.success && result.data) {
                    renderResult(result.data);
                    resultSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                } else {
                    alert('Lỗi: ' + (result.error || 'Không thể chuyển đổi địa chỉ.'));
                }
            } catch (err) {
                console.error('Lỗi chuyển đổi:', err);
                alert('Có lỗi xảy ra trong quá trình kết nối máy chủ.');
            } finally {
                btnConvert.disabled = false;
                btnConvert.innerHTML = originalBtnHtml;
            }
        });
    }

    // Render kết quả ra HTML giao diện
    function renderResult(data) {
        const oldInfo = data.old || {};
        const newInfo = data.new || {};
        const mergeInfo = data.mergeInfo || {};
        const detailUrl = newInfo.detail_url || `https://www.tinhthanhpho.com/${newInfo.province?.slug || ''}/${newInfo.ward?.slug || ''}`;

        const html = `
            <div class="result-grid">
                <!-- ĐỊA CHỈ CŨ -->
                <div class="result-card card-old">
                    <div class="eyebrow-row">
                        <span class="eyebrow eyebrow-old">ĐỊA CHỈ CŨ · TRƯỚC 1/7/2025</span>
                    </div>
                    <div class="result-address" id="old-address-text">${escapeHtml(oldInfo.fullAddress || '')}</div>
                    <hr class="card-divider">
                    <div class="data-table">
                        <div class="data-row">
                            <span class="data-label">Phường/Xã</span>
                            <span class="data-value">${escapeHtml(oldInfo.ward?.type || 'Phường')} ${escapeHtml(oldInfo.ward?.name || '')} <span class="code-tag">#${escapeHtml(oldInfo.ward?.code || '')}</span></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label">Quận/Huyện</span>
                            <span class="data-value">${escapeHtml(oldInfo.district?.type || 'Quận')} ${escapeHtml(oldInfo.district?.name || '')} <span class="code-tag">#${escapeHtml(oldInfo.district?.code || '')}</span></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label">Tỉnh/TP</span>
                            <span class="data-value">${escapeHtml(oldInfo.province?.type || '')} ${escapeHtml(oldInfo.province?.name || '')} <span class="code-tag">#${escapeHtml(oldInfo.province?.code || '')}</span></span>
                        </div>
                    </div>
                </div>

                <!-- ĐỊA CHỈ MỚI -->
                <div class="result-card card-new">
                    <div class="eyebrow-row">
                        <span class="eyebrow eyebrow-new">ĐỊA CHỈ MỚI · TỪ 1/7/2025</span>
                        <span class="badge-success">✓ Khớp chính xác</span>
                    </div>
                    <div class="result-address result-address-new" id="new-address-text">${escapeHtml(newInfo.fullAddress || '')}</div>
                    <hr class="card-divider">
                    <div class="data-table">
                        <div class="data-row">
                            <span class="data-label">Phường/Xã</span>
                            <span class="data-value">${escapeHtml(newInfo.ward?.type || 'Phường')} ${escapeHtml(newInfo.ward?.name || '')} <span class="code-tag">#${escapeHtml(newInfo.ward?.code || '')}</span></span>
                        </div>
                        <div class="data-row">
                            <span class="data-label">Tỉnh/TP</span>
                            <span class="data-value">${escapeHtml(newInfo.province?.type || '')} ${escapeHtml(newInfo.province?.name || '')} <span class="code-tag">#${escapeHtml(newInfo.province?.code || '')}</span></span>
                        </div>
                    </div>

                    <div class="result-actions">
                        <button type="button" class="btn-copy" id="btn-copy-address" data-copy="${escapeHtml(newInfo.fullAddress || '')}">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                                <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                            </svg>
                            <span>Sao chép địa chỉ mới</span>
                        </button>
                        <a href="${detailUrl}" target="_blank" rel="noopener" class="btn-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span>Xem chi tiết ${escapeHtml(newInfo.ward?.type || 'Phường')} ${escapeHtml(newInfo.ward?.name || '')}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Vì sao địa chỉ thay đổi -->
            ${mergeInfo.notes ? `
            <div class="why-box">
                <svg class="why-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 16v-4"/>
                    <path d="M12 8h.01"/>
                </svg>
                <div>
                    <div class="why-title">Vì sao địa chỉ thay đổi?</div>
                    <div class="why-desc">${escapeHtml(mergeInfo.notes)}</div>
                    ${mergeInfo.legal ? `<div class="why-legal">Căn cứ: <strong>${escapeHtml(mergeInfo.legal)}</strong></div>` : ''}
                </div>
            </div>` : ''}

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
                    <pre class="json-pre">${escapeHtml(JSON.stringify(data, null, 4))}</pre>
                </div>
            </details>
        `;

        resultSection.innerHTML = html;
        resultSection.style.display = 'block';

        // Lắng nghe nút copy
        const copyBtn = document.getElementById('btn-copy-address');
        if (copyBtn) {
            copyBtn.addEventListener('click', () => {
                const text = copyBtn.getAttribute('data-copy');
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(text).then(() => {
                        showToast('Đã sao chép địa chỉ mới vào clipboard! ✓');
                    });
                } else {
                    const tempInput = document.createElement('input');
                    tempInput.value = text;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);
                    showToast('Đã sao chép địa chỉ mới vào clipboard! ✓');
                }
            });
        }
    }

    // Helper escape html
    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
});

