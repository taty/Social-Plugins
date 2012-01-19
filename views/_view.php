<?php
if (isset($data['visible']) && $data['visible'] == 1) {
    $opts = array();
    if (isset($data['options'])) {
        $opts = $data['options'];
    }
?>

<div class="social">
    <?php $this->widget('ext.socialplugins.widgets.' . $data['class'], $opts); ?>
</div>

<?php
    }
?>

