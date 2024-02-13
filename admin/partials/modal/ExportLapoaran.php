<div class="modal fade" id="modalExportLaporan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Export Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input class="form-check-input" type="radio" name="filterReport" id="filterReportDay" value="day" />
                        <label class="form-check-label" for="filterReportDay">Hari</label>
                    </div>
                    <div class="col-md-3">
                        <input class="form-check-input" type="radio" name="filterReport" id="filterReportWeek" value="week" />
                        <label class="form-check-label" for="filterReportWeek">Minggu</label>
                    </div>
                    <div class="col-md-3">
                        <input class="form-check-input" type="radio" name="filterReport" id="filterReportMonth" value="month" />
                        <label class="form-check-label" for="filterReportMonth">Bulan</label>
                    </div>
                </div>
                <div>
                    <form method="post" action="action/laporan/penjualan.php" id="form-filter-report">
                        <div class="filter-container d-none">
                            <div>
                                <div class="date-from d-none">
                                    <div class="mb-3">
                                        <label for="date" class="mb-2">Tanggal</label>
                                        <input type="date" class="w-100 p-2 rounded" name="date" id="date" />
                                    </div>
                                </div>
                                <div class="date-to-container d-none">
                                    <div class="mb-3">
                                        <label for="date-to" class="mb-2">Sampai</label>
                                        <input type="date" class="w-100 p-2 rounded" name="date-to" id="date-to" />
                                    </div>
                                </div>
                            </div>
                            <div class="month-container mb-3 d-none">
                                <label for="month" class="mb-2">Bulan</label>
                                <input type="month" class="w-100 p-2 rounded" name="month" id="month" />
                            </div>
                            <input type="hidden" name="filterType" id="filterType" />
                            <button name="btnExportLaporan" class="btn btn-success" id="btnExport">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>