<?php

namespace App\Services;

class EscapeService
{
  /**
   * ベース実行処理
   */
  private function execute(string $code): string
  {
    $tmpFile = tempnam(sys_get_temp_dir(), 'code_') . '.php';
    if (stripos(trim($code), '<?php') !== 0) {
      $code = "<?php\n" . $code;
    }
    file_put_contents($tmpFile, $code);
    $escapedPath = escapeshellarg($tmpFile);
    $command = "php {$escapedPath}";
    $output = shell_exec($command);
    @unlink($tmpFile);
    return trim($output ?? '');
  }

  /**
   * 危険な関数チェック
   */
  private function isSafe(string $code): bool
  {
    $blacklist = ['system', 'exec', 'shell_exec', 'passthru', 'proc_open', 'popen', 'eval', 'file', 'curl'];
    $lower = strtolower($code);
    foreach ($blacklist as $word) {
      if (strpos($lower, $word) !== false) return false;
    }
    return true;
  }

  /**
   * テンプレ：各問題共通ロジック
   */
  private function solveTemplate(string $code, string $expected): array
  {
    if (!$this->isSafe($code)) {
      return [
        'output' => '',
        'correct' => false,
        'error' => '禁止されている関数が含まれています'
      ];
    }

    $output = $this->execute($code);
    return [
      'output' => $output,
      'correct' => $output === $expected
    ];
  }

  public function solve1(string $code): array
  {
    $expected = '10';
    if (!$this->isSafe($code)) {
      return ['output' => '', 'correct' => false, 'error' => '禁止されている関数が含まれています'];
    }

    $output = $this->execute($code);
    $structureErrors = $this->checkStructure($code, [
      ['pattern' => '/\$a\b/', 'message' => '$a を使ってください'],
      ['pattern' => '/\$a\s*=\s*5\s*;/', 'message' => '$a に 5 を代入してください'],
      ['pattern' => '/\*/', 'message' => '掛け算（*）を使ってください'],
    ]);

    return [
      'output' => $output,
      'correct' => $output === $expected && empty($structureErrors),
      'structure_errors' => $structureErrors
    ];
  }

  public function solve2(string $code): array
  {
    $expected = '扉が開いた！';
    if (!$this->isSafe($code)) {
      return ['output' => '', 'correct' => false, 'error' => '禁止されている関数が含まれています'];
    }

    $output = $this->execute($code);
    $structureErrors = $this->checkStructure($code, [
      ['pattern' => '/\$key\b/', 'message' => '$key を使ってください'],
      ['pattern' => '/if\s*\(.*\$key\s*(==|===)\s*(\'|")gold(\'|")\s*\)/', 'message' => '$key が gold の場合であるかどうかの if 文を書いてください']
    ]);

    return [
      'output' => $output,
      'correct' => $output === $expected && empty($structureErrors),
      'structure_errors' => $structureErrors
    ];
  }

  public function solve3(string $code): array
  {
    // 本来の期待出力
    $expected = "ランタン 1 点灯\nランタン 2 点灯\nランタン 3 点灯\nランタン 4 点灯\nランタン 5 点灯";
    if (!$this->isSafe($code)) {
      return [
        'output' => '',
        'correct' => false,
        'error' => '禁止されている関数が含まれています'
      ];
    }
    $output = $this->execute($code);

    $outputCleaned = preg_replace('/\s+/', '', $output);
    $expectedCleaned = preg_replace('/\s+/', '', $expected);

    $structureErrors = $this->checkStructure($code, [
      ['pattern' => '/for\s*\(/', 'message' => 'for文を使ってください']
    ]);

    return [
      'output' => $output,
      'correct' => $outputCleaned === $expectedCleaned && empty($structureErrors),
      'structure_errors' => $structureErrors
    ];
  }

  public function solve4(string $code): array
  {
    $expected = '16';
    if (!$this->isSafe($code)) {
      return ['output' => '', 'correct' => false, 'error' => '禁止されている関数が含まれています'];
    }

    $output = $this->execute($code);
    $structureErrors = $this->checkStructure($code, [
      ['pattern' => '/\[\s*3\s*,\s*5\s*,\s*8\s*\]/', 'message' => '[3, 5, 8] を使ってください'],
      ['pattern' => '/foreach\s*\(/', 'message' => 'foreach を使ってください']
    ]);

    return [
      'output' => $output,
      'correct' => $output === $expected && empty($structureErrors),
      'structure_errors' => $structureErrors
    ];
  }

  public function solve5(string $code): array
  {
    $expected = '10 20';

    if (!$this->isSafe($code)) {
      return [
        'output' => '',
        'correct' => false,
        'error' => '禁止されている関数が含まれています'
      ];
    }

    $output = $this->execute($code);

    $hasLoop = preg_match('/for\s*\(/', $code) || preg_match('/foreach\s*\(/', $code);
    $structureErrors = [];

    if (!$hasLoop) {
      $structureErrors[] = 'for または foreach を使ってください';
    }

    return [
      'output' => $output,
      'correct' => $output === $expected && empty($structureErrors),
      'structure_errors' => $structureErrors
    ];
  }

  public function solve6(string $code): array
  {
    $expected = '';
    for ($i = 2000; $i >= 1; $i--) {
      if ($i % 13 === 0) {
        $expected .= $i;
      }
    }

    if (!$this->isSafe($code)) {
      return [
        'output' => '',
        'correct' => false,
        'error' => '禁止されている関数が含まれています'
      ];
    }

    $output = $this->execute($code);

    return [
      'output' => $output,
      'correct' => $output === $expected,
      'structure_errors' => []
    ];
  }

  public function solve10(string $code): array
  {
    $expected = '10';
    if (!$this->isSafe($code)) {
      return ['output' => '', 'error' => '禁止されている関数が含まれています'];
    }

    $output = $this->execute($code);

    return [
      'output' => $output,
    ];
  }

  /**
   * 構文チェック：必要な構文が使われているかを正規表現で確認
   */
  private function checkStructure(string $code, array $conditions): array
  {
    $messages = [];
    foreach ($conditions as $condition) {
      if (!preg_match($condition['pattern'], $code)) {
        $messages[] = $condition['message'];
      }
    }
    return $messages;
  }

}
