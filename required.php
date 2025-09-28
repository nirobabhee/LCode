//Required * markerd dynamic for all form inputs//


////Medatory JS of form-group in before input //
<script>
$.each($('input, select, textarea'), function (i, element) {
  if (element.hasAttribute('required')) {
    $(element).closest('.form-group').find('label').first().addClass('required');
  }
});
</script>






<style>
////Medatory CSS of form-group in before input //

label.required:after{
    content: '*';
    color: #DC3545!important;
    margin-left: 2px;
}

</style>


//This js or css script use master central -[app.js /app.css//]