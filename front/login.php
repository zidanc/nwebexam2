<fieldset style="margin:auto;padding:10px;width:50%;">
  <legend>會員登入</legend>
    <table>
      <tr>
        <td width="50%" class="clo">帳號</td>
        <td width="50%"><input type="text" name="acc" id="acc"></td>
      </tr>
      <tr>
        <td class="clo">密碼</td>
        <td><input type="password" name="pw" id="pw"></td>
      </tr>
      <tr>
        <td>
          <input type="button" value="登入" onclick="login()">
          <input type="reset" value="清除">
        </td>
        <td>
          <a href="?do=forget">忘記密碼</a> |
          <a href="?do=reg">尚未註冊</a>
         </td>
      </tr>
    </table>

<script>
  function login(){
    // let acc=document.querySelector("#acc").value 等於下方jQuery寫法
    let acc=$("#acc").val();
    let acc=$("#pw").val();
    if(acc=="" || pw==""){
      alert("帳號及密碼欄位不可為空白");
    }else{
      $.get("api/chk_acc.php",{acc},function(res){
        if(res==='1'){
          $.get("api/chk_pw.php",{acc,pw},function(res){
            if(res==='1'){
              location.href="index.php";
            }else{
              alert("密碼錯誤");
              location.reload();
            }
          })
        }else{
          alert("查無帳號");
          location.reload();
        }
      })
    }

  }
</script>


</fieldset>