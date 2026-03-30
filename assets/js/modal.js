/*
 * Universal modal dialog controller
 * - Links whose href is an in-page anchor (#id) will open the dialog
 *   and the inner HTML of the target element will be cloned into it.
 *   this allows you to place forms, iframes, shortcodes etc. anywhere
 *   in the markup (e.g. hidden blocks) and merely link to them.
 * - Uses requestClose/close with Safari 15.4+ fallback
 * - Backdrop click and Escape key close the dialog
*/
(function(){
    'use strict';

    var dialog = document.getElementById('site-modal');
    var modalBody = dialog ? document.getElementById('site-modal-body') : null;

    // helper: return true if anchor points to an element that will act as modal content
    function isModalTarget(href){
        return href && href.charAt(0) === '#';
    }

    function initModalForms(container){
        if (!container) return;

        // For any non-CF7 forms in modal, prevent reload and keep open.
        var otherForms = container.querySelectorAll('form:not(.wpcf7-form)');
        otherForms.forEach(function(form){
            form.addEventListener('submit', function(e){
                e.preventDefault();
            });
        });
    }

    function handleModalSubmit(e){
        var form = e.target;
        if (!form || !form.matches('form')) return;
        if (!form.closest('#site-modal')) return;

        if (form.classList.contains('wpcf7-form')) {
            // CF7 handles submission through its own handler after init.
            return;
        }

        // Non-CF7 forms: prevent default to keep modal open.
        e.preventDefault();
    }

    document.addEventListener('submit', handleModalSubmit, true);

    function openDialog(){
        if (!dialog) return;
        try {
            if (typeof dialog.showModal === 'function') {
                dialog.showModal();
            } else if (typeof dialog.show === 'function') {
                dialog.show();
            } else {
                dialog.setAttribute('open', '');
            }
        } catch (e) {
            if (typeof dialog.show === 'function') dialog.show();
            else dialog.setAttribute('open', '');
        }
    }

    function closeDialog(){
        if (!dialog) return;

        // Сохраняем элемент, который открыл модалку (для возврата фокуса)
        var triggerElement = document.querySelector('[href="#' + modalBody.id + '"]') || document.activeElement;

        // Закрываем диалог
        if (typeof dialog.close === 'function') {
            dialog.close(); // Это стандартный метод для <dialog>
        } else {
            dialog.removeAttribute('open');
        }

        // Очищаем содержимое (опционально), и если форма была перемещена — возвращаем.
        if (modalBody) {
            var moved = modalBody.querySelector('.wpcf7[data-modal-source]');
            if (moved) {
                var sourceId = moved.dataset.modalSource;
                var source = document.querySelector(sourceId);
                if (source) {
                    source.appendChild(moved);
                }
            }
            modalBody.innerHTML = '';
        }

        // Возвращаем фокус (опционально)
        if (triggerElement && typeof triggerElement.focus === 'function') {
            triggerElement.focus();
        }
    }

    document.addEventListener('click', function(e){
        var a = e.target.closest && e.target.closest('a[href]');
        if (!a) return;
        var href = a.getAttribute('href') || '';

        if (isModalTarget(href)) {
            var content = document.querySelector(href);
            if (content) {
                e.preventDefault();
                openDialog();
                if (modalBody) {
                    // If content has CF7 form, move node to keep event handlers.
                    var cf7 = content.querySelector('.wpcf7');
                    if (cf7) {
                        if (cf7.dataset.modalSource) {
                            modalBody.appendChild(cf7);
                        } else {
                            cf7.dataset.modalSource = href;
                            modalBody.appendChild(cf7);
                        }
                    } else {
                        modalBody.innerHTML = content.innerHTML;
                    }
                    initModalForms(modalBody);
                    // Apply custom modal width if specified
                    var modalWidth = content.getAttribute('data-modal-width');
                    if (modalWidth && dialog) {
                        dialog.style.setProperty('--modal-max-width', modalWidth);
                    } else if (dialog) {
                        dialog.style.removeProperty('--modal-max-width');
                    }
                }
            }
        }
    }, true);

    // Handle data-modal-trigger elements (e.g., video overlay)
    document.addEventListener('click', function(e){
        var trigger = e.target.closest && e.target.closest('[data-modal-trigger]');
        if (!trigger) return;

        var contentId = trigger.getAttribute('data-modal-trigger');
        if (contentId) {
            var content = document.getElementById(contentId);
            if (content) {
                e.preventDefault();
                openDialog();
                if (modalBody) {
                    var cf7 = content.querySelector('.wpcf7');
                    if (cf7) {
                        if (cf7.dataset.modalSource) {
                            modalBody.appendChild(cf7);
                        } else {
                            cf7.dataset.modalSource = contentId;
                            modalBody.appendChild(cf7);
                        }
                    } else {
                        modalBody.innerHTML = content.innerHTML;
                    }
                    initModalForms(modalBody);
                    // Apply custom modal width if specified
                    var modalWidth = content.getAttribute('data-modal-width');
                    if (modalWidth && dialog) {
                        dialog.style.setProperty('--modal-max-width', modalWidth);
                    } else if (dialog) {
                        dialog.style.removeProperty('--modal-max-width');
                    }
                }
            }
        }
    }, true);

    // Handle keyboard on modal trigger elements
    document.addEventListener('keydown', function(e){
        if ((e.key === 'Enter' || e.key === ' ') && e.target && e.target.hasAttribute('data-modal-trigger')) {
            e.preventDefault();
            e.target.click();
        }
    }, true);

    if (dialog) {
        // Клик по подложке (backdrop)
        dialog.addEventListener('click', function(e){
            if (e.target === dialog) {
                closeDialog();
            }
        });

        // Событие cancel (Escape)
        dialog.addEventListener('cancel', function(e){
            e.preventDefault();
            closeDialog();
        });

        // Кнопка закрытия
        var closeBtn = dialog.querySelector('.site-modal__close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e){
                e.preventDefault();
                closeDialog();
            });
        }

        // Дополнительный обработчик для закрытия по Escape
        document.addEventListener('keydown', function(e){
            if (e.key === 'Escape' && dialog.open) {
                e.preventDefault();
                closeDialog();
            }
        });
    }

})();