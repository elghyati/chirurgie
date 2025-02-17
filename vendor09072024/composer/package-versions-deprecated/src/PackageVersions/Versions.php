<?php

declare(strict_types=1);

namespace PackageVersions;

use Composer\InstalledVersions;
use OutOfBoundsException;

/**
 * This class is generated by composer/package-versions-deprecated, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 *
 * @deprecated in favor of the Composer\InstalledVersions class provided by Composer 2. Require composer-runtime-api:^2 to ensure it is present.
 */
final class Versions
{
    /**
     * @deprecated please use {@see \Composer\InstalledVersions::getRootPackage()} instead. The
     *             equivalent expression for this constant's contents is
     *             `\Composer\InstalledVersions::getRootPackage()['name']`.
     *             This constant will be removed in version 2.0.0.
     */
    const ROOT_PACKAGE_NAME = '__root__';

    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    const VERSIONS          = array (
  'cocur/slugify' => 'v4.0.0@3f1ffc300f164f23abe8b64ffb3f92d35cec8307',
  'composer/package-versions-deprecated' => '1.10.99@dd51b4443d58b34b6d9344cf4c288e621c9a826f',
  'doctrine/annotations' => '1.10.3@5db60a4969eba0e0c197a19c077780aadbc43c5d',
  'doctrine/cache' => '1.10.2@13e3381b25847283a91948d04640543941309727',
  'doctrine/collections' => '1.6.6@5f0470363ff042d0057006ae7acabc5d7b5252d5',
  'doctrine/common' => '2.13.3@f3812c026e557892c34ef37f6ab808a6b567da7f',
  'doctrine/dbal' => '2.10.2@aab745e7b6b2de3b47019da81e7225e14dcfdac8',
  'doctrine/doctrine-bundle' => '2.1.0@0fb513842c78b43770597ef3c487cdf79d944db3',
  'doctrine/doctrine-migrations-bundle' => '3.0.1@96e730b0ffa0bb39c0f913c1966213f1674bf249',
  'doctrine/event-manager' => '1.1.0@629572819973f13486371cb611386eb17851e85c',
  'doctrine/inflector' => '1.4.3@4650c8b30c753a76bf44fb2ed00117d6f367490c',
  'doctrine/instantiator' => '1.3.1@f350df0268e904597e3bd9c4685c53e0e333feea',
  'doctrine/lexer' => '1.2.1@e864bbf5904cb8f5bb334f99209b48018522f042',
  'doctrine/migrations' => '3.0.1@69eaf2ca5bc48357b43ddbdc31ccdffc0e2a0882',
  'doctrine/orm' => 'v2.7.3@d95e03ba660d50d785a9925f41927fef0ee553cf',
  'doctrine/persistence' => '1.3.7@0af483f91bada1c9ded6c2cfd26ab7d5ab2094e0',
  'doctrine/reflection' => '1.2.1@55e71912dfcd824b2fdd16f2d9afe15684cfce79',
  'doctrine/sql-formatter' => '1.1.0@5458bdcf176f6a53292e3f0cc73f292d6302fb0f',
  'egulias/email-validator' => '2.1.18@cfa3d44471c7f5bfb684ac2b0da7114283d78441',
  'fzaninotto/faker' => 'v1.9.1@fc10d778e4b84d5bd315dad194661e091d307c6f',
  'jms/metadata' => '2.3.0@6eb35fce7142234946d58d13e1aa829e9b78b095',
  'laminas/laminas-code' => '3.4.1@1cb8f203389ab1482bf89c0e70a04849bacd7766',
  'laminas/laminas-eventmanager' => '3.2.1@ce4dc0bdf3b14b7f9815775af9dfee80a63b4748',
  'laminas/laminas-zendframework-bridge' => '1.0.4@fcd87520e4943d968557803919523772475e8ea3',
  'monolog/monolog' => '2.1.0@38914429aac460e8e4616c8cb486ecb40ec90bb1',
  'ocramius/proxy-manager' => '2.2.3@4d154742e31c35137d5374c998e8f86b54db2e2f',
  'phpdocumentor/reflection-common' => '2.2.0@1d01c49d4ed62f25aa84a747ad35d5a16924662b',
  'phpdocumentor/reflection-docblock' => '5.1.0@cd72d394ca794d3466a3b2fc09d5a6c1dc86b47e',
  'phpdocumentor/type-resolver' => '1.3.0@e878a14a65245fbe78f8080eba03b47c3b705651',
  'psr/cache' => '1.0.1@d11b50ad223250cf17b86e38383413f5a6764bf8',
  'psr/container' => '1.0.0@b7ce3b176482dbbc1245ebf52b181af44c2cf55f',
  'psr/event-dispatcher' => '1.0.0@dbefd12671e8a14ec7f180cab83036ed26714bb0',
  'psr/link' => '1.0.0@eea8e8662d5cd3ae4517c9b864493f59fca95562',
  'psr/log' => '1.1.3@0f73288fd15629204f9d42b7055f72dacbe811fc',
  'sensio/framework-extra-bundle' => 'v5.5.6@b49f079d8a87a6e6dd434062085ff5a132af466b',
  'symfony/apache-pack' => 'v1.0.1@3aa5818d73ad2551281fc58a75afd9ca82622e6c',
  'symfony/asset' => 'v5.1.2@2f07b5993f1607c1c489bac3e15a000c33668b4b',
  'symfony/cache' => 'v5.1.2@787eb05e137ad74fa5e51857b9884719760c7b2f',
  'symfony/cache-contracts' => 'v2.1.3@9771a09d2e6b84ecb8c9f0a7dbc72ee92aeba009',
  'symfony/config' => 'v5.1.2@b8623ef3d99fe62a34baf7a111b576216965f880',
  'symfony/console' => 'v5.1.2@34ac555a3627e324b660e318daa07572e1140123',
  'symfony/dependency-injection' => 'v5.1.2@6508423eded583fc07e88a0172803e1a62f0310c',
  'symfony/deprecation-contracts' => 'v2.1.3@5e20b83385a77593259c9f8beb2c43cd03b2ac14',
  'symfony/doctrine-bridge' => 'v5.1.2@997377af37ae96565bf2aea127fb2b6285cd0d51',
  'symfony/dotenv' => 'v5.1.2@42d2a18597f4c7cafc0e25b1ad6a1cbb4f2caf05',
  'symfony/error-handler' => 'v5.1.2@7d0b927b9d3dc41d7d46cda38cbfcd20cdcbb896',
  'symfony/event-dispatcher' => 'v5.1.2@cc0d059e2e997e79ca34125a52f3e33de4424ac7',
  'symfony/event-dispatcher-contracts' => 'v2.1.3@f6f613d74cfc5a623fc36294d3451eb7fa5a042b',
  'symfony/expression-language' => 'v5.1.2@6675d937852379a251017db6e5144dd57506fbbd',
  'symfony/filesystem' => 'v5.1.2@6e4320f06d5f2cce0d96530162491f4465179157',
  'symfony/finder' => 'v5.1.2@4298870062bfc667cb78d2b379be4bf5dec5f187',
  'symfony/flex' => 'v1.9.1@0e752e47d8382361ca2d7ef016f549828185ddb6',
  'symfony/form' => 'v5.1.2@7f0fae286e498aa19ce0c4f737c5bd16cb1ebfba',
  'symfony/framework-bundle' => 'v5.1.2@d9a85deaa9c7a10df087d86f6a689eb5d4db0abc',
  'symfony/http-client' => 'v5.1.2@aae28b613d7a88e529df46e617f046be0236ab54',
  'symfony/http-client-contracts' => 'v2.1.3@cd88921e9add61f2064c9c6b30de4f589db42962',
  'symfony/http-foundation' => 'v5.1.2@f93055171b847915225bd5b0a5792888419d8d75',
  'symfony/http-kernel' => 'v5.1.2@a18c27ace1ef344ffcb129a5b089bad7643b387a',
  'symfony/inflector' => 'v5.1.2@fddb4262dd136b34db993a2a3488713df91e4856',
  'symfony/intl' => 'v5.1.2@b21d69ebb33adfcb7e6d8b0a0a8799db7090705b',
  'symfony/mailer' => 'v5.1.2@203f236f1c2f4d8980f3c4120c8032c8cfe1e893',
  'symfony/mime' => 'v5.1.2@c0c418f05e727606e85b482a8591519c4712cf45',
  'symfony/monolog-bridge' => 'v5.1.2@b275d752c7e999a77e1bddca117e575030a23058',
  'symfony/monolog-bundle' => 'v3.5.0@dd80460fcfe1fa2050a7103ad818e9d0686ce6fd',
  'symfony/notifier' => 'v5.1.2@ca756a1627c02b7b1b0c643f0b1c1d6cb5d792fb',
  'symfony/options-resolver' => 'v5.1.2@663f5dd5e14057d1954fe721f9709d35837f2447',
  'symfony/polyfill-intl-grapheme' => 'v1.18.0@b740103edbdcc39602239ee8860f0f45a8eb9aa5',
  'symfony/polyfill-intl-icu' => 'v1.18.0@4e45a6e39041a9cc78835b11abc47874ae302a55',
  'symfony/polyfill-intl-idn' => 'v1.18.0@bc6549d068d0160e0f10f7a5a23c7d1406b95ebe',
  'symfony/polyfill-intl-normalizer' => 'v1.18.0@37078a8dd4a2a1e9ab0231af7c6cb671b2ed5a7e',
  'symfony/polyfill-mbstring' => 'v1.18.0@a6977d63bf9a0ad4c65cd352709e230876f9904a',
  'symfony/polyfill-php73' => 'v1.18.0@fffa1a52a023e782cdcc221d781fe1ec8f87fcca',
  'symfony/polyfill-php80' => 'v1.18.0@d87d5766cbf48d72388a9f6b85f280c8ad51f981',
  'symfony/process' => 'v5.1.2@7f6378c1fa2147eeb1b4c385856ce9de0d46ebd1',
  'symfony/property-access' => 'v5.1.2@638b96246da68810484a5a46ff397e9326f42afc',
  'symfony/property-info' => 'v5.1.2@75d79faca45092829b55eb83f73068e34c6567c5',
  'symfony/routing' => 'v5.1.2@bbd0ba121d623f66d165a55a108008968911f3eb',
  'symfony/security-bundle' => 'v5.1.2@d2013a73a0163f4fad6d24fbb81affb6e943ec2e',
  'symfony/security-core' => 'v5.1.2@7414e45f720dd81879bd9a74f152ec92e91d36b6',
  'symfony/security-csrf' => 'v5.1.2@962323e4db4458d731d5006f14019a22a2f84b06',
  'symfony/security-guard' => 'v5.1.2@85c368be963e9f0df9e93d830f966fc0af531703',
  'symfony/security-http' => 'v5.1.2@671aeab2db9162288e27c8ef525c63d51c810cb3',
  'symfony/serializer' => 'v5.1.2@d1151fc0fd64b613f2a7012afc22d36b1341a5fd',
  'symfony/service-contracts' => 'v2.1.3@58c7475e5457c5492c26cc740cc0ad7464be9442',
  'symfony/stopwatch' => 'v5.1.2@0f7c58cf81dbb5dd67d423a89d577524a2ec0323',
  'symfony/string' => 'v5.1.2@ac70459db781108db7c6d8981dd31ce0e29e3298',
  'symfony/translation' => 'v5.1.2@d387f07d4c15f9c09439cf3f13ddbe0b2c5e8be2',
  'symfony/translation-contracts' => 'v2.1.3@616a9773c853097607cf9dd6577d5b143ffdcd63',
  'symfony/twig-bridge' => 'v5.1.2@04f57638e591b23d06f72dca2f123605dbbe3a75',
  'symfony/twig-bundle' => 'v5.1.2@8898ef8aea8fa48638e15ce00c7c6318ce570ce1',
  'symfony/twig-pack' => 'v1.0.0@8b278ea4b61fba7c051f172aacae6d87ef4be0e0',
  'symfony/validator' => 'v5.1.2@5e80f314a2faff6fb97942526e27c528b10acdb8',
  'symfony/var-dumper' => 'v5.1.2@46a942903059b0b05e601f00eb64179e05578c0f',
  'symfony/var-exporter' => 'v5.1.2@eabaabfe1485ca955c5b53307eade15ccda57a15',
  'symfony/web-link' => 'v5.1.2@ba2554887e34e693e3888f23f83c72d5ce04bfb2',
  'symfony/yaml' => 'v5.1.2@ea342353a3ef4f453809acc4ebc55382231d4d23',
  'symfonycasts/reset-password-bundle' => 'v1.1.1@ac39892a5de861209cb7491e056a77a0b872e87d',
  'twig/extra-bundle' => 'v3.0.4@a7c5799cf742ab0827f5d32df37528ee8bf5a233',
  'twig/twig' => 'v3.0.4@582bdbdc173027ebfba3c93dc750a40b8f9ebc02',
  'vich/uploader-bundle' => '1.15.0@07658fb47429d7e108fa43d8c74ca8cd7edaa0d9',
  'webmozart/assert' => '1.9.1@bafc69caeb4d49c39fd0779086c03a3738cbb389',
  'doctrine/data-fixtures' => '1.4.3@7ebac50901eb4516816ac39100dba1759d843943',
  'doctrine/doctrine-fixtures-bundle' => '3.3.1@39defca57ee0949e1475c46177b30b6d1b732e8f',
  'nikic/php-parser' => 'v4.6.0@c346bbfafe2ff60680258b631afb730d186ed864',
  'symfony/browser-kit' => 'v5.1.2@b9adef763c4f98660d1f8b924f6d61718f8ae0bc',
  'symfony/css-selector' => 'v5.1.2@e544e24472d4c97b2d11ade7caacd446727c6bf9',
  'symfony/debug-bundle' => 'v5.1.2@3f4bcea52678eedf19260973217f5ae7b835edf5',
  'symfony/dom-crawler' => 'v5.1.2@907187782c465a564f9030a0c6ace59e8821106f',
  'symfony/maker-bundle' => 'v1.20.0@b048c7b2be5bce9024ae3b0db97d44a107029c27',
  'symfony/phpunit-bridge' => 'v5.1.2@de5f0fec631a0cbfe98630b053be1fad7b75aece',
  'symfony/web-profiler-bundle' => 'v5.1.2@25d892ab4927e7df32b0e8dce23cc7a1d4a3bd1c',
  'paragonie/random_compat' => '2.*@8f92c2dc6cec68ee0175046e7bee03171751d6bf',
  'symfony/polyfill-ctype' => '*@8f92c2dc6cec68ee0175046e7bee03171751d6bf',
  'symfony/polyfill-iconv' => '*@8f92c2dc6cec68ee0175046e7bee03171751d6bf',
  'symfony/polyfill-php72' => '*@8f92c2dc6cec68ee0175046e7bee03171751d6bf',
  'symfony/polyfill-php71' => '*@8f92c2dc6cec68ee0175046e7bee03171751d6bf',
  'symfony/polyfill-php70' => '*@8f92c2dc6cec68ee0175046e7bee03171751d6bf',
  'symfony/polyfill-php56' => '*@8f92c2dc6cec68ee0175046e7bee03171751d6bf',
  '__root__' => 'dev-master@8f92c2dc6cec68ee0175046e7bee03171751d6bf',
);

    private function __construct()
    {
        class_exists(InstalledVersions::class);
    }

    /**
     * @throws OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function getVersion(string $packageName): string
    {
        if (class_exists(InstalledVersions::class, false)) {
            return InstalledVersions::getPrettyVersion($packageName)
                . '@' . InstalledVersions::getReference($packageName);
        }

        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }

        throw new OutOfBoundsException(
            'Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files'
        );
    }
}
