<script type="text/javascript">
    $('#frmteacherprofile_submit').click(function(event){
        document.getElementById("frmteacherprofile").submit();
    });
    
    var last_zip = 'x';
    function RefreshCity()
    {
        var postData = {};
        postData.zip = $('#zipCode').val();

        if(last_zip == postData.zip)
            return;

        if(postData.zip.length == 5)
        {
            rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'home/AJAXGetZipData', postData);
            if(rtData && rtData.Valid && rtData.City.length > 0)
            {
                $('#cityData').html(rtData.City);
                $('#cityData').addClass('text-success');
                $('#cityData').removeClass('text-danger');
                return;
            }
        }
        $('#cityData').html("Please enter valid Zip");
        $('#cityData').removeClass('text-success');
        $('#cityData').addClass('text-danger');
    }
    $("#zipCode").on("change keyup paste click", function(){
        RefreshCity();
    });
    $(RefreshCity());
</script>