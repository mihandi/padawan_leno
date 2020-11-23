<form method="get" action="/blog/search" id="myform">
    <div class="search-widget m-b-60">
        <div class="icon-search" onclick="submitFunc()">
           <a class="icon_search" ></a>
        </div>

        <input name="search" id="form-query" value="" placeholder="пошук">

    </div>
</form>


<script>
    function submitFunc() {
        var search_val = document.getElementById("form-query").value;
        if(search_val != '') {
            $("#myform").submit();
        }
    }
</script>
