@if ($paginator->getLastPage() > 1)
<?php $previousPage = ($paginator->getCurrentPage() > 1) ? $paginator->getCurrentPage() - 1 : 1; ?>  
<ul class="pagination" >  
  <li
    class="arrrow{{ ($paginator->getCurrentPage() == 1) ? ' unavailable' : '' }}">
    <a href="{{ $paginator->getUrl($previousPage) }}">&laquo;</a>
  </li>
  @for ($i = 1; $i <= $paginator->getLastPage(); $i++)
  <li
    class="{{ ($paginator->getCurrentPage() == $i) ? 'current' : '' }}">
      <a href="{{ $paginator->getUrl($i) }}">{{ $i }}</a>
  </li>
  @endfor
  <li
    class="{{ ($paginator->getCurrentPage() == $paginator->getLastPage()) ? 'unavailable' : '' }}">
    <a href="{{ $paginator->getUrl($paginator->getCurrentPage()+1) }}">&raquo;</a>
  </li>
</ul>  
@endif