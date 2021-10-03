<footer class="footer d-none d-sm-block">

    <ul class="footer__nav nav justify-content-center">
        <a href="/<?= BASE_PATH ?>dashboard"><?= _("Home") ?></a>
        <a href="#" target="_blank"><?= _("Azienda") ?></a>
        <a href="#"><?= _("Supporto") ?></a>
        <a href="#" target="_blank"><?= _("Contatti") ?></a>
    </ul>

</footer>

<!-- Modal -->
<div class="modal fade" id="modalPop" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalContent">
            </div>
            <div class="modal-footer">
                <div id="modal-content">
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="toaster" aria-live="polite" aria-atomic="true" style="position: absolute; bottom: 50px; right: 50px; min-height: 200px;"></div>