<p align="center">
<a href="https://qtecsolution.com/" target="_blank">
<img src="https://media.licdn.com/dms/image/C510BAQFPADB5GnQEZA/company-logo_200_200/0/1574759253542?e=2147483647&v=beta&t=1cYJ8BJV-mUnLBZlKJEVApQXBj32T6bT2alRbuT_xrw" width="200" alt="qtec Logo">
</a>
</p>

<h1>PixWin_Laravel</h1>

<div style="display: flex;">
    <img src="https://github.com/qtecsolution/alumni_association_laravel/assets/59279508/fdd9cc21-8fc2-4483-aea6-adebfc1acfb2" width="50px" height="50px" alt="Laravel" class="icon">
    <img src="https://upload.wikimedia.org/wikipedia/commons/f/f1/Vue.png" width="50px" height="50px" alt="Vue.js" class="icon">
    <img src="https://w7.pngwing.com/pngs/187/112/png-transparent-responsive-web-design-html-computer-icons-css3-world-wide-web-consortium-css-angle-text-rectangle-thumbnail.png" width="50px" height="50px" alt="html" class="icon">
    <img src="https://img2.freepng.fr/20180816/rcw/kisspng-cascading-style-sheets-logo-clip-art-css3-html-5b7617f67bd3d6.3499284915344660385072.jpg" width="50px" height="50px" alt="CSS" class="icon">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6a/JavaScript-logo.png/800px-JavaScript-logo.png" alt="JavaScript" width="50px" height="50px" class="icon">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Bootstrap_logo.svg/2560px-Bootstrap_logo.svg.png" width="50px" height="50px"  alt="Bootstrap" class="icon">
<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRZr_WNLgW3GKtGV0oyCPZdRC_DvwRrXvPy1f2VQ3pG&s" width="50px" height="50px"  alt="Tailwind" class="icon">
<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f1/Vitejs-logo.svg/1039px-Vitejs-logo.svg.png" width="50px" height="50px"  alt="Bootstrap" class="icon">
</div> 

<p>
    PixWin is an image converter Laravel project that allows users to convert images from one format to another
    seamlessly. This project provides a user-friendly web interface where users can upload their images, select the
    desired output format, and then receive the converted image download link.
</p>

<h2>Table of Contents</h2>
<ul>
    <li><a href="#features">Features</a></li>
    <li><a href="#installation">Installation</a></li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
</ul>

<h2>Features</h2>
<ul>
    <li>Convert images from various formats (e.g., JPG, PNG, GIF) to other formats.</li>
    <li>User-friendly web interface for easy image upload and conversion.</li>
    <li>Fast and efficient image conversion process.</li>
    <li>Download link generation for converted images.</li>
    <li>Responsive design, compatible with various devices.</li>
</ul>

<h2>Installation</h2>
<ol>
<li>Clone the repository from GitHub:</li>
<code>git clone https://github.com/qtecsolution/PixWin_Laravel.git</code>
<code>cd PixWin_Laravel</code>

<li>Install project dependencies using Composer:</li>
<code>composer install</code>

<li>Set up the database and configure the <code>.env</code> file with your database credentials:</li>
<code>cp .env.example .env</code>
<code>php artisan key:generate</code>
<code>php artisan migrate</code>

<li>Start the development server:</li>
<code>php artisan serve</code>

<li>Open your web browser and navigate to <a href="http://localhost:8000">http://localhost:8000</a> to access the
    PicLara application.</li>
</ol>

<h2>Usage</h2>
<ol>
    <li>Register an account or log in if you already have one.</li>
    <li>Once logged in, navigate to the "Home page".</li>
    <li>Upload an image from your local machine or provide a URL to an image hosted online.</li>
    <li>Select the output format you want the image to be converted to (e.g., JPG, PNG, GIF).</li>
    <li>Click the "Convert" button to initiate the conversion process.</li>
    <li>After the conversion is complete, you will receive a download link for the converted image.</li>
    <li>Click the download link to save the converted image to your device.</li>
</ol>

<h2>Contributing</h2>
<p>
    We welcome contributions to enhance the features and fix issues of PicLara. To contribute:
</p>
<ol>
    <li>Fork the repository to your GitHub account.</li>
    <li>Create a new branch from the <code>main</code> branch with a descriptive name for your changes.</li>
    <li>Make your modifications and commit them with clear and concise commit messages.</li>
    <li>Push your changes to your forked repository.</li>
    <li>Submit a pull request to the original repository, detailing the changes you made.</li>
</ol>

<h2>License</h2>
<p>
    This project is licensed under the <a href="LICENSE">MIT License</a>, which means you are free to use, modify, and
    distribute this project with proper attribution to Qtec Solution Limited.
</p>

