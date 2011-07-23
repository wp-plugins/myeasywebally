/**
 * myeasywp.com
 * settings
 * 23 November 2010
 */
function toggleOptions(id) {
	var toggler=document.getElementById(id+'-toggler');
	var contents=document.getElementById(id+'-contents');
	if(toggler && contents) {

		if(contents.style.display=='none') {
			//open element
			contents.style.display='block';
			toggler.className='optionsGroup-toggler-close';
		}
		else {
			//close element
			contents.style.display='none';
			toggler.className='optionsGroup-toggler-open';
		}
	}
}
