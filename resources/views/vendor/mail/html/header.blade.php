<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://ddc.moph.go.th/img/logo_web.png" style="height: 150px; width: 150px" class="logo" alt="DDC">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
