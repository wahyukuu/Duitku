<?php

function isActive($path)
{
  return uri_string() === $path;
}
