<?php
/*this a addon for grocery_crud modded 
* just do $this->mInjectAfterPageTitle = $this->load_inject('gcplug/total', array('totalString' => 'Total', 'column' => 'Column')); 
        or $this->mInjectBeforeFooter = $this->load_inject('gcplug/total', array('totalString' => 'Total', 'column' => 'Column'));
        
*/
$column = isset($column)?$column:0; //<-- you could use $colum name or number, mind display_as is a traslated element, by now...
$totalString = isset($totalString)?$totalString:'Total'; //<-- just traslated string
?>

<section class="content">
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
            <div class="callout callout-danger">
                <h5><?php echo $totalString;?>: <b id="total_total" class="float-right"></b></h5>
            </div>
        </div>
    </div>
</section>
<script>
    var total = [];
    var resetpid = true;
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

    function sumArray(array) {
        let sum = 0,
            index = 0,
            length = array.length;
        for (; index < length; // The "for"-loop condition
            sum += array[index++] // Add number on each iteration
        );
        return sum;
    }

    function reset_total() {
        let index = 0,
            length = total.length;
        for (; index < length; total[index++] = 0);
    }

    function do_total() {
        if (!resetpid) {
            resetpid = true;
            reset_total();
            setTimeout(function() {
                $("#total_total").text(sumArray(total));
                resetpid = false
            }, 300);
        }
    }

    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            do_total();
            let num = indexFromName('<?php echo $column; ?>');
            total[dataIndex] = parseFloat(data[num].replace(",", "."));
            return true;
        });

    setTimeout(function() {
        resetpid = false;
        reset_total();
        oTable.fnDraw();
    }, 900);
</script>