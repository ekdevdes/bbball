bbball 
======
A simple and powerful PHP Client that covers every endpoint of the dribbble api

Installation
------------

Open terminal and paste the following:

`cd the-directory-to-put-bbball-in`

`git clone https://github.com/ekdevdes/bbball.git`

Setup
-----

```php
<?php
  
 include_once 'bbball.php';
 
 $dribbble = new BBBall;
 
```
 
Usage
-----
 
 ```php
 <?php
 // fetch page 2
 $dribbble->page = 2;
 
 // …and lets get 20 shots per page
 $dribbble->per_page = 20;

 // get shots 
 $shots = $dribbble->get_shots();
 
 // get a shot
 $shot = $dribbble->get_shot(43424);
 
 // get a player's info
 $player_info = $dribbble->get_player_info('ethankr');
 
 // get only a shot's rebounds
 $rebounds = $dribbble->get_shot_rebounds(43424);
 
 // get only a shot's comments
 $comments = $dribbble->get_shot_comments(43424);
 
```

Documentation
-------------

After you've included the `bbball.php` file and create a new instance of it here are the methods you can use:

+  `get_shot($id,$show_rebounds=false,$show_comments=false)`
	+ **Gets a single shot from dribbbble**
	+ `$id` `int` The shots id. [Required] [Default: none]
	+ `$show_rebounds` `bool` If true will include the given shot's (the shot is specified by the $id param) rebounds [Optional][Default: false]
	+ `$show_comments` `bool` If true will include the given shot's (the shot is specified by the $id param) comments [Optional][Default: false] 
	+ **Returns: an array of the parsed form of the resulting JSON**
	
+  `get_shots($list="everyone",$player_id=NULL)`
	+ **Gets shots from dribbble with optionally, a few filters**
	+ `$list` `string` The list to fetch the shots from. Either "debuts","everyone","popular","following" or "likes" [Optional][Default: "everyone"]. For "following" or "likes" the `$player_id` must be not NULL 
	+ `$player_id` `int` A given player's id. If not present then will it will be ignored. If present $list will be ignored. [Optional][Default: none]
	<br>
	  NOTE: In order to specify the "following" or "likes" options the `$player_id` must not be NULL
	  <br>
	 NOTE: `$player_id` can either the players actual id or their userame without the '@' in the begining	 
	 + **Returns: an array of the parsed form of the resulting JSON**
+ `get_player_info($id)`
	+ **Get's a players info given a player id.**
	+ `$id` `int` or `string` The player's id [Required][Default: none]. $id can either be the users actual id or their username
	+ **Returns: an array of the parsed form of the resulting JSON**
+ `get_shot_rebounds($id)`
	+ **Gets only a given shot's rebounds**
	+ `$id` `int` the given shot's id
	+ **Returns:  an array of the given shot's (specified by the `$id`) rebounds**
+ `get_shot_comments($id)`
	+ **Gets only a given shot's comments**
	+ `$id` `int` the given shot's id
	+ **Returns: an array of the given shot's (specified by the `$id`) comments**
+ `get_player_shot($id)`
	+ **Gets only a given players shots**
 	+ `$id` `int` or `string` the given players id or username without the '@' sign
  	+ **Returns: an array from the parsed JSON** 
	
Bug Reporter & Feature Requests
------------

Please report any bugs here on Github. 

[http://github.com/ekdevdes/bbball/issues](http://github.com/ekdevdes/bbball/issues)

Thank you.

Contributing
------------

If you would like to contribute to Storage.js please do the following:

+	Fork this repo
+	Make your changes
+	Document the changes using [PHPDoc](http://phpdoc.org)
+	Send me a pull request

Thank you :)

License
-------

bbball IS DOUBLE LICENSED UNDER THE MIT LICENSE AND GPL LICENSE

MIT LICENSE

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

GPL LICENSE

A simple and powerful PHP Dribbble client
	Copyright (C) 2011  Ethan Kramer

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.

bbball 