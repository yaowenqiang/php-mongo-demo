<?php
    include 'conn.php';
    if (isset($_POST['name'])) {
        $people->insert(array(
            'name'=>$_POST['name'],
            'job'=>$_POST['job']
        ));
    }
    $cursor = $people->find();
?>
<form method='POST'>
    <p>
    <input type='text' name='name'>
    </p>
    <p>
    <input type='text' name='job'>
    </p>
    <p>
    <input type='submit' name='submit' value='Add'>
    </p>
</form>
<?php if($cursor->count() > 0 ):?>
    <ul>
    <?php foreach($cursor as $doc):?>
        <li>
        <h1><?php echo $doc['name'];?>( <?php echo $doc['job'];?>)</h1>
            <p><a href='update.php?id=<?php echo $doc['_id'];?>'>Update</a></p>
            <p><a href='delete.php?id=<?php echo $doc['_id'];?>'>Delete</a></p>
        </li>
    <?php endforeach;?>

</ul>
<?php else:?>
    <p>No People</p>
<?php endif ?>
