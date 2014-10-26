<script type="text/javascript">
    function SetObserver(active, pid, sid){
        var postData = {};
        postData.activeStatus = active?1:0;
        postData.PID = pid;
        postData.SID = sid;
        id = pid+"_"+sid;
        pass = false;
        rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'parents/AJAXSetObserver', postData);
        if(rtData)
        {  
            if(rtData.Valid)
            {
                $("#btn_yes_"+id).removeClass(active?"btn-default":"btn-success");
                $("#btn_yes_"+id).addClass(active?"btn-success":"btn-default");
                $("#btn_no_"+id).removeClass(active?"btn-danger":"btn-default");
                $("#btn_no_"+id).addClass(active?"btn-default":"btn-danger");
                pass = true;
            }
        }        
        $("#btn_yes_"+id).blur();
        $("#btn_no_"+id).blur();
        if(!pass)
            alert("Could not change status");
    }
</script>
