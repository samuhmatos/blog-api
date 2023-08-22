<?php
$page = (isset($_GET['page']))? $_GET['page'] : 1;

$prevPage = $page - 1;
$nextPage = $page + 1;
?>
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-start">
        <li class="page-item">
            <?php
                if($prevPage != 0){ ?>
                    <a href="?page=<?=$prevPage; ?>" aria-label="Previous" class="page-link">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                <?php }else{ ?>
                    <a href="#" aria-label="Previous" class="page-link" onclick="return false;">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
            <?php }  ?>
        </li>

        <?php
        //Apresentar a paginacao
        for($i = 1; $i < $num_pages + 1; $i++){ ?>
            <li class="page-item"><a href="?page=<?=$i; ?>" class="page-link"><?=$i; ?></a></li>
        <?php } ?>

        <li class="page-item">
            <?php
            if($nextPage <= $num_pages){ ?>
                <a href="?page=<?=$nextPage; ?>" aria-label="Next" class="page-link">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            <?php }else{ ?>
                <a href="#" aria-label="Next" class="page-link" onclick="return false;">
                    <span aria-hidden="true">&raquo;</span>
                </a>
        <?php }  ?>
        </li>
    </ul>
</nav>
