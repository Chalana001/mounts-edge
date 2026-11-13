
import sharp from "sharp";
import convert from "heic-convert";
import fs from "fs/promises";
import path from "path";

const inputBaseDir = path.resolve("storage/app/public");
const outputBaseDir = path.resolve("storage/app/public-optimized");

const widths = [400, 1000];

async function optimize() {
    const inputArg = process.argv[2];

    if (!inputArg) {
        throw new Error(
            "Please provide an image file path.\n" +
            "Example: node optimize-images.mjs storage/app/public/home/hero/image.HEIC"
        );
    }

    const inputPath = path.resolve(inputArg);

    // Ensure input file exists
    await fs.access(inputPath);

    const extension = path.extname(inputPath).toLowerCase();

    const supportedExtensions = [
        ".jpg",
        ".jpeg",
        ".png",
        ".heic",
        ".heif"
    ];

    if (!supportedExtensions.includes(extension)) {
        throw new Error(`Unsupported image format: ${extension}`);
    }

    // Check whether the image is inside the input directory
    const relativePath = path.relative(inputBaseDir, inputPath);

    if (
        relativePath.startsWith("..") ||
        path.isAbsolute(relativePath)
    ) {
        throw new Error(
            "Image must be inside storage/app/public/"
        );
    }

    const relativeDir = path.dirname(relativePath);

    const baseName = path.basename(
        inputPath,
        extension
    );

    const outputFolder = path.join(
        outputBaseDir,
        relativeDir
    );

    await fs.mkdir(outputFolder, { recursive: true });

    console.log(`Processing: ${inputPath}`);

    // Read original image
    let imageBuffer = await fs.readFile(inputPath);

    // Convert HEIC / HEIF to JPEG in memory
    if (extension === ".heic" || extension === ".heif") {
        console.log("Converting HEIC/HEIF to JPEG...");

        imageBuffer = await convert({
            buffer: imageBuffer,
            format: "JPEG",
            quality: 0.95
        });

        console.log("HEIC/HEIF conversion successful.");
    }

    // Read image metadata
    const metadata = await sharp(imageBuffer).metadata();

    if (!metadata.width || !metadata.height) {
        throw new Error("Unable to read image dimensions.");
    }

    console.log(
        `Image dimensions: ${metadata.width}x${metadata.height}`
    );

    // Generate original-size WebP
    const originalWebpPath = path.join(
        outputFolder,
        `${baseName}.webp`
    );

    await sharp(imageBuffer)
        .rotate()
        .webp({ quality: 80 })
        .toFile(originalWebpPath);

    console.log(`Generated: ${baseName}.webp`);

    // Generate 400w and 1000w JPEG + WebP
    for (const width of widths) {

        if (metadata.width <= width) {
            console.log(
                `Skipped ${width}w: original image width is ${metadata.width}px`
            );
            continue;
        }

        const jpegPath = path.join(
            outputFolder,
            `${baseName}-${width}w.jpg`
        );

        const webpPath = path.join(
            outputFolder,
            `${baseName}-${width}w.webp`
        );

        // JPEG variant
        await sharp(imageBuffer)
            .rotate()
            .resize({
                width,
                withoutEnlargement: true
            })
            .jpeg({
                quality: 82,
                mozjpeg: true
            })
            .toFile(jpegPath);

        // WebP variant
        await sharp(imageBuffer)
            .rotate()
            .resize({
                width,
                withoutEnlargement: true
            })
            .webp({
                quality: 80
            })
            .toFile(webpPath);

        console.log(
            `Generated: ${baseName}-${width}w.jpg`
        );

        console.log(
            `Generated: ${baseName}-${width}w.webp`
        );
    }

    console.log("\n--------------------------------");
    console.log("IMAGE OPTIMIZATION COMPLETED");
    console.log("--------------------------------");

    console.log(`Input: ${inputPath}`);
    console.log(`Output: ${outputFolder}`);

    console.log("--------------------------------");
}

optimize().catch(error => {
    console.error("\nOptimization failed:");
    console.error(error);
    process.exitCode = 1;
});
