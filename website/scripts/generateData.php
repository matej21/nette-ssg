<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

function guidv4()
{
	$data = random_bytes(16);
	$data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
	$data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

	return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}


$container = \App\Bootstrap::boot()->createContainer();
$container->callMethod(function (
	\Nette\Database\Explorer $db,
) {

	$db->query('set search_path to stage_live');
	$categories = array_values($db->table('category')->fetchAll());

	for ($i = 0; $i < 1000; $i++) {
		$title = sprintf('Lorem ipsum %d', $i);
		$db->table('article')->insert([
			'id' => guidv4(),
			'published_at' => (new DateTimeImmutable())->sub(new DateInterval(sprintf('P%dD', random_int(0, 365)))),
			'category_id' => $categories[random_int(0, count($categories) - 1)]->id,
			'title' => $title,
			'slug' => \Nette\Utils\Strings::webalize($title),
			'lead' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.',
			'content' => '
				<p><strong>Pellentesque habitant morbi tristique</strong> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, <code>commodo vitae</code>, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href="#">Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p>

				<h2>Header Level 2</h2>

				<ol>
				   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
				   <li>Aliquam tincidunt mauris eu risus.</li>
				</ol>

				<blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue. Ut a est eget ligula molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis mollis, tellus est malesuada tellus, at luctus turpis elit sit amet quam. Vivamus pretium ornare est.</p></blockquote>

				<h3>Header Level 3</h3>

				<ul>
				   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
				   <li>Aliquam tincidunt mauris eu risus.</li>
				</ul>',
		]);
	}
});
