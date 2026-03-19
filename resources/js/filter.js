document.addEventListener('DOMContentLoaded', function() {
    const products = document.querySelectorAll('.card-product');
    const filterButtons = document.querySelectorAll('.select-item');
    const availabilityInputs = document.querySelectorAll('input[name="availability"]');
    const brandInputs = document.querySelectorAll('input[name="brand"]');
    const colorItems = document.querySelectorAll('#color ~ .dropdown-menu .check-item');
    const sizeItems = document.querySelectorAll('#size ~ .dropdown-menu .check-item');
    const priceRangeInput = document.getElementById('price-value-range');
    const priceMinValue = document.getElementById('price-min-value');
    const priceMaxValue = document.getElementById('price-max-value');
    const resetPriceBtn = document.querySelector('.reset-price');
    const removeAllBtn = document.getElementById('remove-all');
    const appliedFiltersDiv = document.getElementById('applied-filters');
    const sortValue = document.querySelector('.text-sort-value');
    const listLayout = document.getElementById('listLayout');
    const gridLayout = document.getElementById('gridLayout');
    const wrapperShop = document.querySelector('.wrapper-shop');

    let filters = {
        sort: 'best-selling',
        availability: [],
        brand: [],
        color: [],
        size: [],
        priceMin: 0,
        priceMax: 500
    };

    // Sort functionality
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const sortValue = this.getAttribute('data-sort-value');
            filters.sort = sortValue;
            
            // Update UI
            document.querySelectorAll('.select-item').forEach(item => {
                item.classList.remove('active');
            });
            this.classList.add('active');
            
            // Update sort value display
            document.querySelector('.text-sort-value').textContent = this.querySelector('.text-value-item').textContent;
            
            applyFilters();
        });
    });

    // Availability filter
    availabilityInputs.forEach(input => {
        input.addEventListener('change', function() {
            filters.availability = [];
            availabilityInputs.forEach(inp => {
                if (inp.checked) {
                    filters.availability.push(inp.id === 'inStock' ? 'In stock' : 'Out of stock');
                }
            });
            applyFilters();
        });
    });

    // Brand filter
    brandInputs.forEach(input => {
        input.addEventListener('change', function() {
            filters.brand = [];
            brandInputs.forEach(inp => {
                if (inp.checked) {
                    const brandName = inp.nextElementSibling.textContent.trim().split('\n')[0].trim();
                    filters.brand.push(brandName);
                }
            });
            applyFilters();
        });
    });

    // Color filter - improved with proper click handling
    colorItems.forEach(item => {
        item.style.cursor = 'pointer';
        item.addEventListener('click', function() {
            this.classList.toggle('active');
            updateColorFilters();
            applyFilters();
        });
    });

    function updateColorFilters() {
        filters.color = [];
        colorItems.forEach(item => {
            if (item.classList.contains('active')) {
                const colorText = item.querySelector('.color-text');
                if (colorText) {
                    filters.color.push(colorText.textContent.trim());
                }
            }
        });
    }

    // Size filter - improved with proper click handling
    sizeItems.forEach(item => {
        item.style.cursor = 'pointer';
        item.addEventListener('click', function() {
            this.classList.toggle('active');
            updateSizeFilters();
            applyFilters();
        });
    });

    function updateSizeFilters() {
        filters.size = [];
        sizeItems.forEach(item => {
            if (item.classList.contains('active')) {
                const sizeText = item.querySelector('.size');
                if (sizeText) {
                    filters.size.push(sizeText.textContent.trim());
                }
            }
        });
    }

    // Price range filter
    if (priceRangeInput) {
        priceRangeInput.addEventListener('input', function() {
            const minVal = parseInt(this.value) || 0;
            filters.priceMin = minVal;
            updatePriceDisplay();
            applyFilters();
        });
    }

    function updatePriceDisplay() {
        if (priceMinValue) priceMinValue.textContent = filters.priceMin.toLocaleString('vi-VN');
        if (priceMaxValue) priceMaxValue.textContent = filters.priceMax.toLocaleString('vi-VN');
    }

    // Reset price filter
    if (resetPriceBtn) {
        resetPriceBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            filters.priceMin = 0;
            filters.priceMax = 500;
            if (priceRangeInput) priceRangeInput.value = 0;
            updatePriceDisplay();
            applyFilters();
        });
    }

    // Apply filters
    function applyFilters() {
        let visibleCount = 0;
        let colorCounts = {};
        let sizeCounts = {};

        // Initialize counts
        colorItems.forEach(item => {
            const colorName = item.getAttribute('data-color-name');
            if (colorName) colorCounts[colorName] = 0;
        });

        sizeItems.forEach(item => {
            const sizeName = item.querySelector('.size')?.textContent.trim();
            if (sizeName) sizeCounts[sizeName] = 0;
        });

        products.forEach(product => {
            let show = true;

            // Check availability
            if (filters.availability.length > 0) {
                const availability = product.getAttribute('data-availability');
                show = show && filters.availability.includes(availability);
            }

            // Check brand
            if (filters.brand.length > 0) {
                const brand = product.getAttribute('data-brand');
                show = show && filters.brand.includes(brand);
            }

            // Check color and count
            if (show) {
                const colorTexts = product.querySelectorAll('.color-text');
                colorTexts.forEach(color => {
                    const colorName = color.textContent.trim();
                    if (colorCounts.hasOwnProperty(colorName)) {
                        colorCounts[colorName]++;
                    }
                });
            }

            // Check size and count
            if (show) {
                const sizeElements = product.querySelectorAll('.size-item, .size');
                sizeElements.forEach(sizeEl => {
                    const sizeText = sizeEl.textContent.trim();
                    if (sizeCounts.hasOwnProperty(sizeText)) {
                        sizeCounts[sizeText]++;
                    }
                });
            }

            // Show or hide product
            product.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });

        // Update counts in UI
        updateFilterCounts(colorCounts, sizeCounts);

        // Sort products
        sortProducts();

        // Update applied filters display
        updateAppliedFilters();

        // Update product count
        updateProductCount(visibleCount);

        // Show/hide remove all button
        const hasFilters = filters.availability.length > 0 || filters.brand.length > 0 || 
                          filters.color.length > 0 || filters.size.length > 0;
        if (removeAllBtn) {
            removeAllBtn.style.display = hasFilters ? 'inline-block' : 'none';
        }
    }

    function sortProducts() {
        if (!wrapperShop) return;

        const visibleProducts = Array.from(products).filter(p => p.style.display !== 'none');

        visibleProducts.sort((a, b) => {
            switch(filters.sort) {
                case 'a-z':
                    const nameA = a.querySelector('.name-product')?.textContent || '';
                    const nameB = b.querySelector('.name-product')?.textContent || '';
                    return nameA.localeCompare(nameB, 'vi');
                case 'z-a':
                    const nameA2 = a.querySelector('.name-product')?.textContent || '';
                    const nameB2 = b.querySelector('.name-product')?.textContent || '';
                    return nameB2.localeCompare(nameA2, 'vi');
                case 'price-low-high':
                    const priceA = extractPrice(a);
                    const priceB = extractPrice(b);
                    return priceA - priceB;
                case 'price-high-low':
                    const priceA2 = extractPrice(a);
                    const priceB2 = extractPrice(b);
                    return priceB2 - priceA2;
                default: // best-selling
                    return 0;
            }
        });

        // Reorder products in DOM
        visibleProducts.forEach(product => {
            wrapperShop.appendChild(product);
        });
    }

    function extractPrice(element) {
        const priceText = element.querySelector('.price-new')?.textContent || '0';
        const numbers = priceText.replace(/[^\d]/g, '');
        return parseInt(numbers) || 0;
    }

    function updateAppliedFilters() {
        if (!appliedFiltersDiv) return;

        let appliedArray = [];

        if (filters.availability.length > 0) {
            appliedArray.push(`<span class="filter-tag">Tình trạng: ${filters.availability.join(', ')}</span>`);
        }

        if (filters.brand.length > 0) {
            appliedArray.push(`<span class="filter-tag">Thương hiệu: ${filters.brand.join(', ')}</span>`);
        }

        if (filters.color.length > 0) {
            appliedArray.push(`<span class="filter-tag">Màu: ${filters.color.join(', ')}</span>`);
        }

        if (filters.size.length > 0) {
            appliedArray.push(`<span class="filter-tag">Kích cỡ: ${filters.size.join(', ')}</span>`);
        }

        appliedFiltersDiv.innerHTML = appliedArray.join(' ');
    }

    function updateFilterCounts(colorCounts, sizeCounts) {
        // Update color counts
        colorItems.forEach(item => {
            const colorName = item.getAttribute('data-color-name');
            const countSpan = item.querySelector('.count');
            if (colorName && colorCounts.hasOwnProperty(colorName)) {
                if (!countSpan) {
                    const newCountSpan = document.createElement('span');
                    newCountSpan.className = 'count';
                    item.appendChild(newCountSpan);
                }
                item.querySelector('.count').textContent = `(${colorCounts[colorName]})`;
            }
        });

        // Update size counts
        sizeItems.forEach(item => {
            const sizeText = item.querySelector('.size')?.textContent.trim();
            const countSpan = item.querySelector('.count');
            if (sizeText && sizeCounts.hasOwnProperty(sizeText)) {
                if (!countSpan) {
                    const newCountSpan = document.createElement('span');
                    newCountSpan.className = 'count';
                    item.appendChild(newCountSpan);
                }
                item.querySelector('.count').textContent = `(${sizeCounts[sizeText]})`;
            }
        });
    }

    // Clear all filters
    if (removeAllBtn) {
        removeAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Reset filters
            filters = {
                sort: 'best-selling',
                availability: [],
                brand: [],
                color: [],
                size: [],
                priceMin: 0,
                priceMax: 500
            };

            // Reset UI
            availabilityInputs.forEach(input => input.checked = false);
            brandInputs.forEach(input => input.checked = false);
            colorItems.forEach(item => item.classList.remove('active'));
            sizeItems.forEach(item => item.classList.remove('active'));

            if (priceRangeInput) priceRangeInput.value = 0;

            document.querySelectorAll('.select-item').forEach(item => {
                item.classList.remove('active');
            });
            document.querySelector('.select-item')?.classList.add('active');
            document.querySelector('.text-sort-value').textContent = 'Bán chạy nhất';

            updatePriceDisplay();
            applyFilters();
        });
    }

    // Layout switcher
    const layoutSwitches = document.querySelectorAll('.tf-view-layout-switch');
    layoutSwitches.forEach(switcher => {
        switcher.addEventListener('click', function() {
            layoutSwitches.forEach(sw => sw.classList.remove('active'));
            this.classList.add('active');

            const layout = this.getAttribute('data-value-layout');
            if (layout === 'list') {
                if (listLayout) listLayout.style.display = 'block';
                if (gridLayout) gridLayout.style.display = 'none';
            } else {
                if (listLayout) listLayout.style.display = 'none';
                if (gridLayout) {
                    gridLayout.style.display = 'grid';
                    gridLayout.classList.add('tf-grid-layout');
                    gridLayout.classList.add(layout);
                }
            }
        });
    });

    // Initialize price display
    updatePriceDisplay();
});
