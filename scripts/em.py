from scipy.stats import norm
import numpy as np
from pprint import pprint as pprint
# NOTE: To run this code, you may need to run: 
#       `pip install scipy`
#       `pip install numpy` 
#       if you have not already installed numpy and scipy.
# I'm using numpy v1.17.

# When using numeric values, it is recommended to use numpy arrays for efficiency. 
# See https://stackoverflow.com/a/994010
# One drawback of this is that we have to explicitly define array size during initialization,
# rather than having dynamically changing array size.


# TODO: define function signature
# This function takes input from PHP and converts it to a convenient format
def read_input():

    
    # Assuming 2 distributions (i.e. binary classification)
    DIST_COUNT = 2
    # TODO: actual data input from PHP
    temp_points = np.array(1, 2, 3);

    expectation_maximization(DIST_COUNT, temp_points)


# Performs the Expectation Maximization algorithm as described in:
# Clustering for malware classification; Pai et al. (2016)
# 
def expectation_maximization(k, temp_points, distributions=[]):
    # Initialize parameters (mean, variance)

    # I'm using standard python lists for distributions;
    # since distribution objects aren't numbers, they can't be put in numpy arrays.
    if(distributions == []):
        distributions = init_random_distributions(k)

    old_means = get_means(distributions)

    # Using an arbitrary multiplier to ensure we enter loop
    # (because python doesn't have do-while loops)
    ARBITRARY_MULTIPLIER = 1.1
    new_means = [mean * ARBITRARY_MULTIPLIER for mean in old_means]

    # Alternate between E and M step until change is negligable
    while(significant_mean_change(old_means, new_means)):
        old_means = new_means
        # TODO: modify 'changed' based on exp. and max. function outputs

        # E step: Compute probabilities needed in M step, based on
          # current estimates of the distribution parameters
        expectation()

        # M Step: Use the probabilities from the E step to recompute
          # the distribution parameters, based on 
          # maximum likelihood estimators
        maximization()
        new_means = get_means(distributions)
    return []

# Using mean with difference 1e-6 as suggested in:
# Analysis of stopping critera for the EM algorithm, Abbi et al.
#
# Using this for simplicity of implementation, even though using variance 
# would be a more accurate heuristic.
def significant_mean_change(old_means, new_means):

    MINIMUM_CHANGE = 1e-6

    for i, mean in enumerate(old_means):
        normalized_diff = abs((old_means[i] - new_means[i]) / old_means[i])
        if normalized_diff > MINIMUM_CHANGE:
            return True

    # If we get here, all of our diffs are small
    return False


def get_means(dist_list): 
    return [dist.means() for dist in dist_list]


def init_random_distributions(count):
    # For now, assuming we can have any float as a mean or SD.

    # TODO: These values are somewhat arbitrary. Do we need to adjust them?
    RANDOM_MEAN_RANGE = 5
    MIN_RANDOM_MEAN = -2.5
    
    MAX_RANDOM_SD = 5
    # Standard deviations are always positive!
    # Setting minimum to epsilon to keep it nonzero 
    # (who knows what that might do...)
    MIN_RANDOM_SD = np.finfo(float).eps

    dists = []
    for i in range(count):
        mean = np.random.default_rng().random()
        mean = (mean * RANDOM_MEAN_RANGE) + MIN_RANDOM_MEAN

        # sd = np.random.default_rng().uniform(MIN_RANDOM_SD, MAX_RANDOM_SD)
        sd = np.random.default_rng().random()
        sd = (sd * MAX_RANDOM_SD) + MIN_RANDOM_SD

        new_dist = norm(mean, sd)
        # TODO: remove these debug print statements
        print("mean:", new_dist.mean())
        print("sd  :", new_dist.std())
        print()
        dists.append(new_dist)
    return dists


# TODO: define function signature
def expectation():
    return


# TODO: define function signature
def maximization():
    return


