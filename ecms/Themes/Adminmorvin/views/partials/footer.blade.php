<div class="modal fade" id="keyboardShortcutsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    {{ trans('core::core.general.available keyboard shortcuts') }}
                </h4>
            </div>
            <div class="modal-body">
                @yield('shortcuts')
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script>
                © <b>Version</b> {{ $version }}
                @yield('footer')
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Created with <i class="mdi mdi-heart text-danger"></i> by TecnoDesign
                </div>
            </div>
        </div>
    </div>
</footer>

