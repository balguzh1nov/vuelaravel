// src/s3.js
import AWS from 'aws-sdk';

AWS.config.update({
  accessKeyId: process.env.VUE_APP_AWS_ACCESS_KEY_ID,
  secretAccessKey: process.env.VUE_APP_AWS_SECRET_ACCESS_KEY,
  region: process.env.VUE_APP_AWS_DEFAULT_REGION,
});

const s3 = new AWS.S3();

export async function uploadFile(file) {
  const params = {
    Bucket: process.env.VUE_APP_AWS_BUCKET,
    Key: `documents/${file.name}`,
    Body: file,
    ACL: 'public-read',
  };

  try {
    const data = await s3.upload(params).promise();
    return data.Location;
  } catch (error) {
    console.error('Error uploading file:', error);
    throw error;
  }
}
