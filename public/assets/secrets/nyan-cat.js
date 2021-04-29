document.styleSheets[0].disabled = true;
document.body.style.backgroundColor = '';

let audio = document.querySelector('#audio');
audio.volume = 0.2;

function cycleFrames (_nyanCat, _currentFrame) {
	_nyanCat.classList = []
	_nyanCat.classList.add(`frame${_currentFrame}`)
}

(function () {
	let nyanCat = document.getElementById('nyan-cat')
	let currentFrame = 1

	setInterval(function () {
		currentFrame = (currentFrame % 6) + 1
		cycleFrames(nyanCat, currentFrame)
	}, 70)
})();