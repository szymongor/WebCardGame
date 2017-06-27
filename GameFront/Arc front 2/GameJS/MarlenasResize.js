var max_width = 300;

function resize_image(img) {
	 if(img.width > max_width) {
        // obliczamy proporcje szerokość do wysokość
        factor = img.width / img.height;
        // obliczamy proporcjonalną wysokość, zaokrąglamy ją używając Math.floor();
        height = Math.floor(max_width / factor);
        // nadajemy obrazkowi nowe wymiary
        img.width = max_width;
        img.height = height;
    }
}
