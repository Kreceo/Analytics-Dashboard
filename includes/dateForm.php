<form class="container-fluid py-4" method="GET" id="dateRangeForm">
    <div class="d-flex flex-wrap flex-lg-nowrap align-items-start align-items-sm-end flex-column flex-sm-row">
        <div class="d-flex flex-wrap flex-lg-nowrap flex-column flex-sm-row">
            <div class="form-group mr-2 mb-0">
                <label>Start Date</label>
                <input type="date" class="form-control" name="start" id="start" value="<?php echo isset($_GET['start']) ? $_GET['start'] : '2021-04-27'; ?>" required>
            </div>
            <div class="form-group px-0 px-sm-3 mb-0">
                <label>End Date</label>
                <input name="end" type="date" class="form-control" id="end" value="<?php echo isset($_GET['end']) ? $_GET['end'] : date("Y-m-d"); ?>" required>
            </div>
        </div>
        <div class="mr-3 py-3 p-sm-0 text-nowrap">
            <p class="mb-0">Compared to</p>
        </div>
        <div class="d-flex align-items-start align-items-sm-end flex-wrap flex-lg-nowrap flex-column flex-sm-row w-100">
            <div class="form-group ml-2 mr-2 mb-0">
                <label>Start Date</label>
                <input type="date" class="form-control" name="cStart" id="cStart" value="<?php echo isset($_GET['cStart']) ? $_GET['cStart'] : '2021-03-26'; ?>">
            </div>
            <div class="form-group px-0 px-sm-3 mb-0">
                <label>End Date</label>
                <input name="cEnd" type="date" class="form-control" id="cEnd" value="<?php echo isset($_GET['cEnd']) ? $_GET['cEnd'] : '2021-04-26'; ?>">
            </div>
            <button type="submit" class="btn btn-primary mb-0 mt-3 mt-sm-0" style="max-height: 40px;">Submit</button>
        </div>
    </div>
    <input type="hidden" name="pageId" value="<?php echo $_GET['pageId'] ?? '41918623'; ?>">
</form>