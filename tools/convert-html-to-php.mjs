import { promises as fs } from 'fs';
import path from 'path';

const root = '/home/crimson/Jr-Ayshan';
const bootstrapPath = path.join(root, 'includes', 'php', 'bootstrap.php');

async function walk(dirPath) {
  const entries = await fs.readdir(dirPath, { withFileTypes: true });
  const files = [];

  for (const entry of entries) {
    const absolutePath = path.join(dirPath, entry.name);
    if (entry.isDirectory()) {
      files.push(...await walk(absolutePath));
    } else {
      files.push(absolutePath);
    }
  }

  return files;
}

function toPhpPath(htmlPath) {
  return htmlPath.replace(/\.html$/i, '.php');
}

function relativeBootstrapRequire(filePath) {
  const folder = path.dirname(filePath);
  return path.relative(folder, bootstrapPath).split(path.sep).join('/');
}

function addPhpPrelude(contents, filePath) {
  const requirePath = relativeBootstrapRequire(filePath);
  const prelude = `<?php\nrequire_once __DIR__ . '/${requirePath}';\n$pageSlug = jr_page_slug();\n?>\n`;
  return contents.startsWith('<?php') ? contents : prelude + contents;
}

function rewriteHtmlReferences(contents) {
  return contents.replace(/(["'`])([^"'`\n]*?)\.html(\?[^"'`\n]*)?(#[^"'`\n]*)?\1/g, (_match, quote, prefix, query = '', hash = '') => {
    return `${quote}${prefix}.php${query}${hash}${quote}`;
  }).replace(/\.html\b/g, '.php');
}

async function convertHtmlFile(filePath) {
  const phpPath = toPhpPath(filePath);
  const contents = await fs.readFile(filePath, 'utf8');
  const updated = addPhpPrelude(contents, phpPath);
  await fs.writeFile(phpPath, updated, 'utf8');
  await fs.unlink(filePath);
}

async function main() {
  await fs.mkdir(path.dirname(bootstrapPath), { recursive: true });

  const allFiles = await walk(root);
  const htmlFiles = allFiles.filter(filePath => filePath.endsWith('.html'));

  for (const htmlFile of htmlFiles) {
    await convertHtmlFile(htmlFile);
  }

  const postConvertFiles = await walk(root);
  const textFiles = postConvertFiles.filter(filePath => /\.(php|js|md|sh|ps1)$/i.test(filePath));

  for (const filePath of textFiles) {
    const contents = await fs.readFile(filePath, 'utf8');
    const updated = rewriteHtmlReferences(contents);
    if (updated !== contents) {
      await fs.writeFile(filePath, updated, 'utf8');
    }
  }

  const indexPath = path.join(root, 'index.php');
  const indexContents = `<?php\nheader('Location: dashboard.php');\nexit;\n`;
  await fs.writeFile(indexPath, indexContents, 'utf8');
}

main().catch(error => {
  console.error(error);
  process.exit(1);
});