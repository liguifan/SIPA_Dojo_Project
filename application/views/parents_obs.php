<div id="contentWrapperHeader" class="clearfix">
  <span class="hdtext fleft">Observers</span>
  <a href="<?php echo my_base_URL();?>parents/addobs" class="btn btn-default fright">Add Observer</a>
</div>
<div class="container-fluid">
    <?php if(!isset($Obs) || !isset($Obs['Parents']) || (count($Obs['Parents']) == 0)) { ?>
    You have no observers. please add observer first.
    <?php } else { ?>
    <table class="table table-bordered sttable">
        <colgroup>
            <col width="2*">
            <col width="2*">
            <?php foreach($Obs['Students'] as $Student) { ?>
                <col width="3*">
            <?php } ?>
        </colgroup>
        <thead>
            <tr>
                <th>Observer &#8659;</th>
                <th class='text-right'>Student &#8658;</th>
                <?php foreach($Obs['Students'] as $Student) { ?>
                    <th class='text-center'> <?php echo $Student['Name']; ?> </th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach($Obs['Parents'] as $PID => $Parent) { ?>
        <tr><td colspan='2'><?php echo $Parent['Name']; ?></td>
            <?php foreach($Obs['Students'] as $SID => $Student) { 
                $btnID = $PID."_".$SID;
                $classYes = (array_search($PID, $Student['Map']) !== false) ? "btn-success":"btn-default";
                $classNo  = (array_search($PID, $Student['Map']) !== false) ? "btn-default":"btn-danger";
                ?>
                <td class='text-center'>  
                    <div class="btn-group">
                        <button type="button" id="btn_yes_<?php echo $btnID;?>" onclick="javascript:SetObserver(true, <?php echo "$PID, $SID";?>);"  class="btn <?php echo $classYes; ?>">&#10004;</button>
                        <button type="button" id="btn_no_<?php echo $btnID;?>"  onclick="javascript:SetObserver(false, <?php echo "$PID, $SID";?>);" class="btn <?php echo $classNo; ?>">&#10006;</button>
                    </div>
                </td>
            <?php } ?>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } ?>
</div>
