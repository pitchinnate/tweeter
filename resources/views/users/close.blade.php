<script>
    var uid = "{{$uid}}";
    var token = "{{$token}}";
    //call parent function here sending uid and token
    parent.sendToken(token,'Bearer',uid);
    //close myself
    self.close();
</script>
Login Successful!