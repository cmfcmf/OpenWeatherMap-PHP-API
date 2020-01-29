const user = "cmfcmf";
const project = "OpenWeatherMap-PHP-API";
const githubUserUrl = `https://github.com/${user}`;
const githubUrl = `${githubUserUrl}/${project}`;

const title = project.replace(/-/g, " ");

module.exports = {
  title: title,
  tagline: 'A PHP API to parse weather data and weather history from OpenWeatherMap.org.',
  url: 'https://christianflach.de',
  baseUrl: `/${project}/`,
  favicon: 'img/favicon.ico',
  organizationName: user, // Usually your GitHub org/user name.
  projectName: project, // Usually your repo name.
  themeConfig: {
    navbar: {
      title: title,
      logo: {
        alt: 'Sun Logo',
        src: 'img/logo.svg',
      },
      links: [
        {to: 'docs/getting-started', label: 'Docs', position: 'left'},
        {
          href: githubUrl,
          label: 'GitHub',
          position: 'right',
        },
      ],
    },
    footer: {
      style: 'dark',
      links: [
        {
          title: 'PHP API Docs',
          items: [
            {
              label: 'Getting Started',
              to: 'docs/getting-started',
            },
            {
              label: 'API Key',
              to: 'docs/api-key',
            },
            {
              label: 'Usage',
              to: 'docs/usage',
            },
          ],
        },
        {
          title: "Official Resources",
          items: [
            {
              label: 'Introduction Guide',
              href: 'https://openweathermap.org/guide'
            },
            {
              label: 'Pricing',
              href: 'https://openweathermap.org/price'
            }
          ]
        },
        {
          title: 'Christian Flach',
          items: [
            {
              label: 'GitHub',
              href: githubUserUrl,
            },
            {
              label: 'Twitter',
              href: 'https://twitter.com/christianmflach',
            },
            {
              label: 'Privacy / Datenschutz',
              href: `https://${user}.github.io/about`
            }
          ],
        },
      ],
      copyright: `Copyright © ${new Date().getFullYear()} Christian Flach.
      This project is not affiliated with OpenWeatherMap.`,
    },
    disableDarkMode: true, // dark mode requires localstorage, which requires a cookie banner. We don't want the cookie banner.
    sidebarCollapsible: false,
  },
  presets: [
    [
      '@docusaurus/preset-classic',
      {
        docs: {
          sidebarPath: require.resolve('./sidebars.js'),
          editUrl:
            `${githubUrl}/edit/master/docs`,
          showLastUpdateAuthor: true,
          showLastUpdateTime: true
        },
        theme: {
          customCss: require.resolve('./src/css/custom.css'),
        },
      },
    ],
  ],
  plugins: [
    // require('path').resolve(__dirname, '../../docusaurus-search-local'),
    '@cmfcmf/docusaurus-search-local'
  ]
};
