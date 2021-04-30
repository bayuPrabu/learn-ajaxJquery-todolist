<html>
<head>
	<meta charset="UTF-8">
	<title>To do List</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<h3>To <strong>do List</strong>.</h3>
				<table class="table">
					<thead id="thead"></thead>
					<tbody id="content"></tbody>
				</table>
				<form action="" id="create-form">
					<div class="form-group">
						<label for="create-input" style="font-weight: bold">Name :</label>
						<input type="text" placeholder="content..." id="create-input">
					</div>
					<div>
						<h6 class="help-block error-message"></h6>
					</div>
					<div>
						<button class="btn btn-sm btn-default" style="border-color: lightgrey">Create</button>
					</div>
					
				</form>
			</div>
		</div>
	</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
	$(document).ready(function(){
		/*let todos = [
			{name: "html", is_completed: false},
			{name: "css", is_completed: true}
		];*/

		let todos = JSON.parse(localStorage.getItem("lists")) || [];

		// Tambah tabel head
		let todohead = $("#thead");
		todohead.append(`
			<tr>
				<th>No.</th>
				<th>Nama</th>
				<th>Keterangan</th>
				<th>Hapus</th>
			</tr>
		`);

		// CRUD
		let app = {
			// Menampilkan Data
			show: function(){
				let todoname = $("#content");
				todoname.html("");

				if(todos.length>0){
					todos.forEach(function(value, index){
						let classtodo = "badge " +(value.is_completed ? 'badge-success' : 'badge-danger');
						let complete = (value.is_completed) ? "" : "complete";

						// Tambah isi tabel 
						todoname.append(`
							<tr style="cursor:pointer">
								<td>${(index+1)}</td>
								<td class="name ${complete}" >${value.name}</td>
								<td><span class="${classtodo} boolean" id="${value.name}">${value.is_completed}</span></td>
								<td><a href="" class="delete badge badge-warning">delete</a></td>
							</tr>
							`)
					$(".complete").css({"text-decoration-line": "line-through"})
					})	
				}else{
					todoname.append('<tr><td colspan="4" class="bg-secondary text-center text-white">Name is empty</td></tr>')
				}
			},

			// Read Data Error
			showError : function(pesan){
				$(".error-message").html(pesan).css({"color":"red"}).slideDown("slow");
				setTimeout(function(){
					$(".error-message").html("")
				}, 5000)
			},

			// Save Data
			save: function(data){
				data.preventDefault();
				let input = $("#create-input");
				let text = input.val();
				let errorMessage = null;

				// Pesan error
				if(text === ""){
					errorMessage = "nama wajib diisi"
				} else if(text.match(/[^A-z]/g)) {
					errorMessage = "Mohon jangan input angka"
				} else {
					todos.forEach(function(value, index){
						if(value.name === text){
							errorMessage = "nama sudah ada"
						}
					})
				}

				// Jalankan Fungsi error
				if(errorMessage){
					app.showError(errorMessage);
					return false
				}

				// Tambah data list
				todos.push({
					name:text,
					is_completed:true
				});

				// Local storage
				localStorage.setItem("lists", JSON.stringify(todos))

				input.val("")
				app.show();
			},

			// Toggle Boolean Pada List Nama
			toggle: function(key){
				todos.forEach(function(value, index){
					if(value.name === $(this).text()){
						value.is_completed = !value.is_completed
					}
				}.bind(this)) /*mengacu objek yg dipilih*/
				app.show();
			},

			// Toggle Boolean Pada List Keterangan
			toggleValue: function(){
				todos.forEach(function(value, index){
					if(value.name === $(this).attr("id")){
						value.is_completed = !value.is_completed
					}
				}.bind(this)) /*mengacu objek yg dipilih*/
				app.show();
			},

			// Delete data
			delete: function(event){
				event.preventDefault(); /*mencegah sifat asli dari href*/
				let text = $(this).parent("td").prev().prev().text();
				let notice = confirm("Yakin Hapus Data Ini ?")

				todos.forEach(function(value, index){
					if(notice === true) {
						if(value.name === text){
							console.log(index)
							todos.splice(index, 1)
						}
					}
					localStorage.setItem("lists", JSON.stringify(todos))
				})
				app.show();
			}
		}

		// Jalankan Fungsi to do list 
		app.show();
		$("#create-form").on("submit", app.save);
		$(document).on("click", ".name", app.toggle);
		$(document).on("click", ".boolean",app.toggleValue);
		$(document).on("click", ".delete", app.delete);
	})
</script>
</body>
</html>