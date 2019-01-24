function myfun(id){
	
	swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this record!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
	  window.location = "../delete/"+id;
    
  } else {
    swal("The record is safe!");
  }
});
}