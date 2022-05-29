<!-- Menghubungkan dengan view template master -->
@extends('layout.main')

<!-- isi bagian judul halaman -->
<!-- cara penulisan isi section yang pendek ryrt-->
@section('title', 'Record')


<!-- isi bagian konten -->
<!-- cara penulisan isi section yang panjang -->
@section('content')

<div class="row align-items-md-stretch">
  <div class="col-md-6">
    <div class="h-100 p-5 bg-light border rounded-3">
      <h2>Select Your Time</h2>

      <form class="row g-3">
        <div class="col-12">
          <select class="form-select sel-dur" aria-label="Default select
            example">
            <option value="">-- Select Duration --</option>
            <option value="540">09:00</option>
            <option value="480">08:00</option>
            <option value="720">12:00</option>
            <option value="60">01:00</option>
          </select>
        </div>
        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck">
            <label class="form-check-label" for="gridCheck">
              Check me out
            </label>
          </div>
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-outline-secondary">Submit</button>
        </div>
      </form>


    </div>
  </div>
  <div class="col-md-6">
    <div class="h-100 p-5 text-white bg-dark rounded-3">
      <h2>Time Is Money</h2>
      <h1 id="time">...</h1>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores,
        ipsum? Lorem ipsum dolor sit amet.</p>
    </div>
  </div>

</div>

<hr>

<div class="p-5 mb-4 border bg-light rounded-3">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">First</th>
        <th scope="col">Last</th>
        <th scope="col">Handle</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">1</th>
        <td>Mark</td>
        <td>Otto</td>
        <td>@mdo</td>
      </tr>
      <tr>
        <th scope="row">2</th>
        <td>Jacob</td>
        <td>Thornton</td>
        <td>@fat</td>
      </tr>
      <tr>
        <th scope="row">3</th>
        <td colspan="2">Larry the Bird</td>
        <td>@twitter</td>
      </tr>
    </tbody>
  </table>
</div>

<!-- <p>Nama : {{ $name }}</p>
 
	<p>Mata Pelajaran</p>
	<ul>

		@foreach($arr as $m)
 
		<li>{{ $m }}</li>
 
		@endforeach
		
	</ul> -->
<!-- <div>Registration closes in <span id="time">05:00</span> minutes!</div> -->
<script>
    //console.log('dad');

	

// window.onload = function () {
//     var fiveMinutes = 60*59;
//     //     display = document.querySelector('#time');
//     // startTimer(fiveMinutes, display);
//     getTime(fiveMinutes);
// };


$('.sel-dur').on('change', function() {
    var dur = $(this).val();
    console.log(dur);
    getTime(dur);
});

var prevNowPlaying = null;

function getTime(duration) {

    if (prevNowPlaying) {
        clearInterval(prevNowPlaying);
    }

    display = document.querySelector('#time');
    var timer = duration, minutes, seconds;

    prevNowPlaying = setInterval(function () {
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

				var res = minutes + ":" + seconds;
       
        if (--timer < 0) {
            //timer = duration;
            // var ex = 
            // res = "-" + res.replace('-','');
            //console.log('ddd');
        }
        
        display.textContent = res;
    }, 1000);

}
</script>

@endsection