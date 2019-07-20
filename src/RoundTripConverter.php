<?php
namespace Pulsestorm\CommonMark;
use League\CommonMark\EnvironmentInterface;
use League\CommonMark\Environment;
use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\HtmlRenderer;
use League\CommonMark\Converter;
use League\CommonMark\DocParser;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Extension\CommonMarkCoreExtension;

class RoundTripConverter extends Converter {
    /**
     * The currently-installed version.
     *
     * This might be a typical `x.y.z` version, or `x.y-dev`.
     */
    const VERSION = '0.0.1';

    /** @var EnvironmentInterface */
    protected $environment;

    protected $markdownRenderer;

    /**
     * Create a new commonmark converter instance.
     *
     * @param array                     $config
     * @param EnvironmentInterface|null $environment
     */
    public function __construct(array $config = [], EnvironmentInterface $environment = null)
    {
        if ($environment === null) {
            $environment = new Environment();
            $environment->addExtension(new RoundTripExtension());
            $environment->mergeConfig([
                'renderer' => [
                    'block_separator' => "\n",
                    'inner_separator' => "\n",
                    'soft_break'      => "\n",
                ],
                'html_input'         => Environment::HTML_INPUT_ALLOW,
                'allow_unsafe_links' => true,
                'max_nesting_level'  => INF,
            ]);
        }

        if ($environment instanceof ConfigurableEnvironmentInterface) {
            $environment->mergeConfig($config);
        }

        $this->environment = $environment;

        parent::__construct(new DocParser($environment), new HtmlRenderer($environment));
    }

    /**
     * @return EnvironmentInterface
     */
    public function getEnvironment(): EnvironmentInterface
    {
        return $this->environment;
    }

    public function convertToMarkdown(string $commonMark): string
    {
        $documentAST = $this->docParser->parse($commonMark);
        return $this->htmlRenderer->renderBlock($documentAST);
    }

}
