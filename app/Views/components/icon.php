<?php

function icon($name, $class = 'w-5 h-5')
{
  $icons = [
    'dashboard' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="' . $class . '" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>',

    'check' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="' . $class . '" viewBox="0 0 24 24" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>',

    'chart' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="' . $class . '" viewBox="0 0 24 24" stroke-width="2"><path d="M3 3v18h18"/><path d="M7 14v4"/><path d="M12 10v8"/><path d="M17 6v12"/></svg>',

    'download' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="' . $class . '" viewBox="0 0 24 24" stroke-width="2"><path d="M12 3v12"/><path d="m7 10 5 5 5-5"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/></svg>',

    'user' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="' . $class . '" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>',

    'perencanaan' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="' . $class . '" viewBox="0 0 24 24" stroke-width="2"><path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6h.01"/><path d="M3 12h.01"/><path d="M3 18h.01"/></svg>',

    'rekening' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="' . $class . '" viewBox="0 0 24 24" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>',

    'kategori' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="' . $class . '" viewBox="0 0 24 24" stroke-width="2"><path d="M20 12V8a2 2 0 0 0-2-2h-4"/><path d="M4 12V8a2 2 0 0 1 2-2h4"/><path d="M12 12v8"/><path d="M8 16h8"/></svg>',

    'logout' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="' . $class . '" viewBox="0 0 24 24" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>',
  ];

  return $icons[$name] ?? '';
}
