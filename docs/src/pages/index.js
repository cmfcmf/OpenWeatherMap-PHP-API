import React from 'react';
import classnames from 'classnames';
import Layout from '@theme/Layout';
import Link from '@docusaurus/Link';
import useDocusaurusContext from '@docusaurus/useDocusaurusContext';
import useBaseUrl from '@docusaurus/useBaseUrl';
import styles from './styles.module.css';

const features = [
  {
    title: <>Supports most free APIs</>,
    description: (
      <>
        <p>This project comes with support for five of the most popular free APIs:</p>
        <ul>
          <li>Current Weather Data</li>
          <li>16-day/daily Forecast Data</li>
          <li>5-day/3-hourly Forecast Data</li>
          <li>Air Pollution (CO, O3, SO2, NO2) Data</li>
          <li>Ultraviolet Index Data</li>
        </ul>
      </>
    ),
  },
  {
    title: <>Easy to Use</>,
    description: (
      <p>
        The OpenWeatherMap APIs are poorly documented and oftentimes not easy to use. This project provides the necessary abstractions to make working with the API feel like a breeze.
      </p>
    ),
  },
  {
    title: <>Powered by modern PHP</>,
    description: (
      <p>
        Since version 3.x, this project works with PHP 7.x.
        It uses <a href="https://www.php-fig.org/psr/psr-17/">PSR-17</a> and <a href="https://www.php-fig.org/psr/psr-18/">PSR-18</a> for
        HTTP requests, as well
        as <a href="https://www.php-fig.org/psr/psr-6/">PSR-6</a> for caching.
      </p>
    ),
  },
];

function Feature({imageUrl, title, description}) {
  const imgUrl = useBaseUrl(imageUrl);
  return (
    <div className={classnames('col col--4', styles.feature)}>
      {imgUrl && (
        <div className="text--center">
          <img className={styles.featureImage} src={imgUrl} alt={title} />
        </div>
      )}
      <h3>{title}</h3>
      {description}
    </div>
  );
}

function Home() {
  const context = useDocusaurusContext();
  const {siteConfig = {}} = context;
  return (
    <Layout
      title={siteConfig.title}
      description={siteConfig.tagline}>
      <header className={classnames('hero hero--primary', styles.heroBanner)}>
        <div className="container">
          <h1 className="hero__title">{siteConfig.title}</h1>
          <p className="hero__subtitle">{siteConfig.tagline}</p>
          <div className={styles.buttons}>
            <Link
              className={classnames(
                'button button--outline button--secondary button--lg',
                styles.getStarted,
              )}
              to={useBaseUrl('docs/getting-started')}>
              Get Started
            </Link>
          </div>
        </div>
      </header>
      <main>
        {features && features.length && (
          <section className={styles.features}>
            <div className="container">
              <div className="row">
                {features.map((props, idx) => (
                  <Feature key={idx} {...props} />
                ))}
              </div>
            </div>
          </section>
        )}
      </main>
    </Layout>
  );
}

export default Home;
