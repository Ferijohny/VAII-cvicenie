<div class = "form-group text-danger">
    @foreach($errors->all() as $error)
        {{$error}}<br>
    @endforeach
</div>
<form method="post" action="{{$action}}" enctype="multipart/form-data">
    @csrf
    @method($method)
    <div class="form-group">
        <label for="name">Cottage name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Cottage name" value="{{old('name', @$model->name )}}">
    </div>
    <div class="form-group">
        <label for="desc">Description of cottage</label>
        <textarea type="desc" class="form-control" aria-label="With textarea" id="desc" name="desc" placeholder="Description" >{{{ old('desc', @$model->desc ) }}}</textarea>
{{--        <input type="desc" class="form-control" id="desc" name="desc"--}}
{{--               placeholder="Description" value="{{old('desc', @$model->desc )}}">--}}
    </div>
    <div class="form-group">
        <label for="locality">Locality</label>
        <input type="locality" class="form-control" id="locality" name="locality" placeholder="locality" value="{{old('locality', @$model->locality )}}">
    </div>
    <div class="form-group">
        <label for="num_ppl">Maximum number of people</label>
        <input type="num_ppl" class="form-control" id="num_ppl" name="num_ppl" placeholder="Number of people" value="{{old('num_ppl', @$model->num_ppl )}}">
    </div>
    <label>Image</label>
    <div class="form-group">
        <label for ="file">Choose file</label>
        <input type="file" name="file" class="form-control" onchange="previewFile(this)">
        <img id="previewImg" alt="image" style="max-width: 130px;margin-top:20px;">

    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<script>
    function previewFile(input){
        var file=$("input[type=file]").get(0).files[0];
        if(file)
        {
            var reader = new FileReader();
            reader.onload = function ()
            {
                $('#previewImg').attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
    }
</script>
