<!DOCTYPE html>
<html>
<body>

<section>
  <h1>WWF</h1>
  <p>The World Wide Fund for Nature (WWF) is an international organization working on issues regarding the conservation, research and restoration of the environment, formerly named the World Wildlife Fund. WWF was founded in 1961.</p>
</section>

<section>
  <form action="{{route('testing.nama')}}" method="POST">
    @csrf
    <button>testing</button>
  </form>
</section>

</body>
</html>

