@extends('template',["react" => "1"])
@section('title', 'React Example01')
@section('content')
<div id="mydiv"></div>

<script type="text/babel">
  function Hello1() {
    return <h1>Hello World!</h1>;
  }

  const container = document.getElementById('mydiv');
  const root = ReactDOM.createRoot(container);
  root.render(<Hello1 />)
</script>
@endsection
        