<?php
    if(isset($_SESSION['message'])): 
?>
<div class="alert">
    <?= $_SESSION['message'];?>
</div>

<?php
    unset($_SESSION['message']);
    endif;
?>