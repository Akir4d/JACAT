<?php
/*this a addon for grocery_crud modded 
* just do $this->mInjectAfterPageTitle = $this->load_inject('gcplug/between2date', array('column' => 'tot', 'title' => 'Search by date', 'search_button' => 'Search', 'lang' => 'en', 'auto' => true)); 
        or $this->mInjectBeforeFooter = $this->load_inject('gcplug/between2date', array('column' => 'tot', 'title' => 'Search by date', 'search_button' => 'Search', 'lang' => 'en', 'auto' => true));
        you could use $colum name or number, mind display_as is a traslated element, by now...
*/
$column = isset($column) ? $column : 0; //<-- you could use $colum name or number, mind display_as is a traslated element, by now...
$title = isset($title) ? $title : 'Search by date';
$search_button = isset($search_button) ? $search_button : 'Search';
$lang =  isset($lang) ? $lang : 'en'; //<-- choose lang
$auto = isset($auto) ? $auto : true; //<-- choose if you want automatic or manual search date
?>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><?php echo $title; ?></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div id="min"></div>
                    </div>
                    
                    <?php if (!$auto) : ?>
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <div id="max"></div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-default" onclick="doDateSearch()"><?php echo $search_button; ?></button>
                        </div>
                    <?php else : ?>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div id="max"></div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $dateSearchStart = false;

    function indexFromName(searchindex) {
        let ret = 0;
        let val = parseInt(searchindex.charAt(0));
        console.log(val);
        if (isNaN(val)) {
            $("table.groceryCrudTable > thead > tr[id!=multiSearchToggle] > th").each(function(index) {
                if (searchindex.toLowerCase() === $(this).text().toLowerCase()) {
                    ret = index + 1
                };
            });
        } else {
            ret = searchindex;
        }
        return parseInt(ret);
    }

    function initdatetime() {
        $('#min').datetimepicker({
            format: 'L',
            inline: true,
            locale: '<?php echo $lang; ?>',
            sideBySide: true,
            defaultDate: '<?php echo date('Y') ?>-01-01'
        });

        $('#max').datetimepicker({
            format: 'L',
            inline: true,
            locale: '<?php echo $lang; ?>',
            sideBySide: true
        });

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                if ($dateSearchStart) {
                    let min = $('#min').datetimepicker('date').unix();
                    let max = $('#max').datetimepicker('date').unix();
                    let datain = data[indexFromName('<?php echo $column; ?>')];
                    let datafix = datain.slice(6, 10) + '-' + datain.slice(3, 5) + '-' + datain.slice(0, 2);
                    let age = Date.parse(datafix) / 1000;
                    if ((isNaN(min) && isNaN(max)) ||
                        (isNaN(min) && age <= max) ||
                        (min <= age && isNaN(max)) ||
                        (min <= age && age <= max)) {
                        return true;
                    }
                    return false;
                } else {
                    return true;
                }
            }
        );


        <?php if ($auto) : ?>
            $('#min, #max').on("change.datetimepicker", function() {
                doDateSearch();
            });
        <?php endif; ?>
    }

    async function doDateSearch() {
        $dateSearchStart = true;
        await oTable.fnDraw();
        $dateSearchStart = false;
    }

    $(document).ready(function() {
        initdatetime();
    });
</script>