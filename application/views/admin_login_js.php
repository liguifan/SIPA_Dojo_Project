<script type="text/javascript">
function AJAXLogin(type)
{
    var postData = {};
    postData.username = $("#adminLogin #username").val();
    postData.password = $("#adminLogin #password").val();

    var errorText = "";

    rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'admin/AJAXLogin', postData);
    if(rtData)
    {
        if(rtData.UserID > 0){
            redirect_url(rtData.Redirect);
            return;}
        else
            errorText = "Invalid username or password.";
    }
    else
        errorText = "Could not connect to server.";
    
    $("#adminLogin #errorText").html(errorText);
    $("#adminLogin #errorText").parent().removeClass('hidden');
}
</script>
