<?php
require'dbconnection.php';
$action = (isset($_POST['action'])) ? $_POST['action']:'default';
//function for validating the input date
function validateInput(){
    if (empty($_POST['year']) || empty($_POST['month']) || empty($_POST['day'])) {
        return False;
    }
    $timestamp = strtotime($_POST['year'] .'-'.$_POST['month'].'-'.$_POST['day']);
    if (!is_numeric($timestamp)) {
        return False;
    }
    return checkdate(date('m',$timestamp),date('d',$timestamp),date('Y',$timestamp));
}
switch ($action) {
    case 'Show':
        if (validateInput() === True) {
            $inputValidated = True;
            //query MongoDB collection to get sales data for user-supplied date
            $date  = sprintf('%d-%d-%d',$_POST['year'],$_POST['month'],$_POST['day']);
            $mongodate = new MongoDate(strtotime($date));
            $mongodb= DBConnection::instantiate();
            $collection = $mongodb->getCollection('daily_sales');
            $doc = $collection->findOne(array('sales_date'=>$mongodate));
        } else {
            $inputValidated = False;
        }
        break;

    default:
        break;
}
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel='stylesheet' href='../style.css'>
        <title>Daily Sales of Acme Products</title>
    </head>
    <body>
        <div id='contentarea'>
            <div id='innercontentarea'>
                <h2>Daily Sales of Acme Products</h2>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method='post'>
                    Enter Date (YYYY-MM-DD)
                    <input id="year" type="text" name="year" size='4'> -
                    <input id="month" type="text" name="month" size='2'> -
                    <input id="day" type="text" name="day" size='2'>
                    <input type="submit" value="Show" name='action'>
                </form>
                <?php if($action === 'Show'):
                    if($inputValidated === True):?>
                <h2><?php echo date('F j,Y',$mongodate->sec);?></h2>
                <?php if(!empty($doc)):?>
                <table class="table-list" cellspacing='0' cellpadding='0'>
                    <thead>
                        <tr>
                            <th width='50%'>Item</th>
                            <th widh='25%'>&nbsp;</th>
                            <th width='*'>Units Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($doc['items'] as $item => $unitsSold):?>
                        <td><?php echo $item;?></td>
                        <td>&nbsp;</td>
                        <td><?php echo $unitsSold;?></td>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <?php else:
                    echo '<p>No sales record found.</p>';
                endif;
                else:
                    echo '<h3>Invalid input.Try again.</h3>';
                endif;
                endif;?>
            </div>
        </div>
    </body>
</html>
