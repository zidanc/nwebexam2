<fieldset style="margin:auto;padding:10px;width:50%;">
  <legend>忘記密碼</legend>
    <table style="width:100%;">
      <tr>
        <td width="100%"><input style="width:95%" type="text" name="email" id="email"></td>
      </tr>
      <tr>
        <td id="result"></td>
      </tr>
      <tr>
        <td>
          <input type="button" value="尋找" onclick="findPw()">
        </td>
      </tr>
    </table>

<script>
  function findPw(){
    // let acc=document.querySelector("#acc").value 等於下方jQuery寫法
    let email=$("#email").val();
    if(email==""){
      alert("帳號及密碼欄位不可為空白");
    }else{
      $.get("api/find_pw.php",{email},function(res){
        $("#result").html(res)

      })
    }

  }
</script>


</fieldset>