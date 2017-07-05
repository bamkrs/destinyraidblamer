function highlightPlayerTable(type,value,better)
{
	$('[name="playerTable'+type+'Value"]').each(function(index,element)
		{
			if(parseFloat($(element).text())>value)
			{
				element.style.color=better?"rgb(0,255,0)":"rgb(255,0,0)";
			}
			else
			{
				element.style.color=better?"rgb(255,0,0)":"rgb(0,255,0)";
			}

		});
}
function normalPlayerTable(type)
{
	$('[name="playerTable'+type+'Value"]').each(function(index,element)
		{
			element.style.color = null;
		});
}

function searchNewGuardian(btn)
{
	location.href="/"+btn.value+"/"+document.getElementById("guardianSearchInput").value;
}