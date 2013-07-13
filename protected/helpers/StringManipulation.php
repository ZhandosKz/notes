<?php
class StringManipulation
{
	public static function truncate($html, $maxLength )
	{
		$printedLength = 0;
		$position = 0;
		$tags = array();

		while ($printedLength < $maxLength && preg_match('{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;}', $html, $match, PREG_OFFSET_CAPTURE, $position))
		{
			list($tag, $tagPosition) = $match[0];

			// Print text leading up to the tag.
			$str = substr($html, $position, $tagPosition - $position);
			if ($printedLength + strlen($str) > $maxLength)
			{
				print(substr($str, 0, $maxLength - $printedLength));
				$printedLength = $maxLength;
				break;
			}

			print($str);
			$printedLength += strlen($str);

			if ($tag[0] == '&')
			{
				// Handle the entity.
				print($tag);
				$printedLength++;
			}
			else
			{
				// Handle the tag.
				$tagName = $match[1][0];
				if ($tag[1] == '/')
				{
					// This is a closing tag.

					$openingTag = array_pop($tags);
					assert($openingTag == $tagName); // check that tags are properly nested.

					print($tag);
				}
				else if ($tag[strlen($tag) - 2] == '/')
				{
					// Self-closing tag.
					print($tag);
				}
				else
				{
					// Opening tag.
					print($tag);
					$tags[] = $tagName;
				}
			}

			// Continue after the tag.
			$position = $tagPosition + strlen($tag);
		}

		// Print any remaining text.
		if ($printedLength < $maxLength && $position < strlen($html))
			print(substr($html, $position, $maxLength - $printedLength));

		// Close any open tags.
		while (!empty($tags))
			printf('</%s>', array_pop($tags));
	}
}