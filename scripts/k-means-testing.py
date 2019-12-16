import numpy as np
import random

import fileinput
import sys

clusterNum = []     # total number of data points in each cluster

finalCentroids = []		# Centroids used in the current model, will be placed at random locations
                    # This value will be a double because it holds the average value of all data points in the cluster
finalCentroidsNum = []
data_cluster =[]	# Array containing the connection between data points and centroids
                    # [ [data point], centroid index ]
                    # [ [data point], centroid index ]
                    # ...

data_points = []	# List containing all the data points


# This is the first function used as it initializes the global variables used in other methods
# This function takes input from the PHP webpage and converts it to a HashMap consisting of 
# INPUT fileText (String)    - Text of the user uploaded file
# INPUT centroids (String) - amount of clusters the user defined
# INPUT dim (Integer)        - dimension of data points in the file
def km_test_init(fileText, centroids):
    
    #dimension = dim
    #clusterAmount = num

    # File Text is split into data points separated by array
    splitLine = fileText.split("\\n")
    for y in splitLine:
        dataPointInt = []
        dataPointString = y.split(" ")
        for x in dataPointString:
            if(x != ''):
                val = float(x)
                # Adding a value to the data point
                dataPointInt.append(val)
        
            # Append data point to list of data points
        if(len(dataPointInt)!= 0):
            data_points.append(dataPointInt)
                
    cString = centroids.replace('"', '')
    splitLine = cString.split("[")
    for a in splitLine:
        point =[]
        if(a != ''):
            a = a.replace(']', '')
            arr = a.split(",")
            
            for i in arr:
                if(i != ''):
                    val = float(i)
                    point.append(val)
        if(len(point)!= 0):
            finalCentroids.append(point)
            finalCentroidsNum.append(0)

    print()
    print("These are the Final Centroid values: ")
    print()
    index = 0
    for a in finalCentroids:
        print("Cluster ", index, ": ", a)
        index = index+1
    print()

                # Assign centroids to data points using a the data_cluster 2 dimensional array
    for p in data_points:
        # Outputs index of centroid this point is closest to and creates an array to hold this tuple
        c_index = compareCluster(p)
        cluster_assign = [p, c_index]
        # Adds the data point as a key of the point and value of the  centroid's index in the array
        data_cluster.append(cluster_assign)

    print("This is the final data_cluster: ")
    print("Format: [data point], [cluster value]")
    print()
    for a in data_cluster:
        print(a)

# Eucilidian - this distance calculus is independent of dimensions.
# For example, a model with 4 dimensional points will have its distance computes as: d(a,b) = sqrt( (a1-b1)^2 + (a2-b2)^2 + (a3-b3)^2 + (a4-b4)^2 )
# INPUT p1, p2: Points to compare the Eucilidian distance between
# OUTPUT: Distance between the two points
def km_distance(p1, p2):
    total = 0
    
    # Allows selection for both data points as arrays
    index = 0
    for y in p2:
        total += np.square((p1[index]-p2[index]))
    return np.sqrt(total)

# This method compares the distance between a point and all of the Centroids in the centroids array
# INPUT p: Point to compare with all the centroids
# OUTPUT: Index of the centroid the point is closest to
def compareCluster(p):
    dist = km_distance(p, finalCentroids[0])
    centroid = 0;
    index = 0;
    for x in finalCentroids:
        val = km_distance(p, x)
        if(val < dist):
            dist = val
            centroid = index
        index = index + 1
    return centroid

text = sys.argv[1].split('Z')
if(len(text) == 2):
    km_init(text[0], text[1]);
else:
    print("The input values are too short: ", sys.argv[1])

sys.stdout.flush
sys.stdin.close
sys.stdout.close
